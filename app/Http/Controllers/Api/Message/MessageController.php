<?php

namespace App\Http\Controllers\Api\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Conversation;
use App\Services\MessageService;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class MessageController extends Controller
{
    /**
     *  __construct
     *
     * @param \App\Services\MessageService $messageService
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * Show list messages
     *
     * @return JsonResponse
     */

    public function listMessage($conversationId, Request $request)
    {
        try {
            $user = Auth::guard('api')->user();
            $conversation = Conversation::with(['users', 'messages.user'])
                                ->where('id', $conversationId)
                                ->first();
            // Kiểm tra quyền truy cập
            if ($conversation && $conversation->users->contains($user)) {
                $messages = $conversation->messages()
                    ->orderBy('created_at', 'asc')
                    ->with('user')
                    ->get();
                if ($conversation->users->count() == 2) {
                    $otherUser = $conversation->users->where('id', '!=', $user->id)->first();
                    $conversationInfo = [
                        'name' => $otherUser->full_name,
                        'avatar' => $otherUser->avatar,
                        'type' => 'user',
                    ];
                } else {
                    $conversationInfo = [
                        'name' => $conversation->name ?: $conversation->users->pluck('full_name')->implode(', '),
                        'avatar' => null,
                        'type' => 'group',
                    ];
                }
            } else {
                return response()->json(
                    [
                        'error' => 'Không tìm thấy cuộc trò chuyện nào!'
                    ], Response::HTTP_FORBIDDEN
                );
            }
            return response()->json(
                [
                    'messages' => $messages,
                    'conversationInfo' => $conversationInfo,
                    'msg' => 'Hiển thị danh sách tin nhắn thành công!'
                ], Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage());
        }

    }


    public function listConversation(Request $request)
    {
        try {
            $user = Auth::guard('api')->user();

            $usersInConversations = DB::table('user_conversation')
            ->join('conversations', 'user_conversation.conversation_id', '=', 'conversations.id')
            ->leftJoin('users', 'user_conversation.user_id', '=', 'users.id')
            ->leftJoin('messages', 'conversations.id', '=', 'messages.conversation_id')
            ->whereIn('conversations.id', function ($query) use ($user) {
                $query->select('conversation_id')
                    ->from('user_conversation')
                    ->where('user_id', $user->id);
            })
            ->select(
                'conversations.id as conversation_id',
                'conversations.name as conversation_name',
                'users.id as user_id',
                'users.full_name',
                'users.avatar',
                DB::raw('MAX(messages.created_at) as message_time')
            )
            ->groupBy('conversations.id', 'conversations.name', 'users.id', 'users.full_name', 'users.avatar')
            ->orderBy('message_time', 'desc')
            ->get()
            ->groupBy('conversation_id');
            
            return response()->json(
                [
                    'conversations' => $usersInConversations,
                    'msg' => 'Hiển thị danh sách cuộc trò chuyện thành công!'
                ], Response::HTTP_OK
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage());
        }
    }
    public function sendMessage(MessageRequest $request)
    {

        try {
            $message = $this->messageService->send($request);
            return response()->json([
                'message' => $message,
                'msg' => 'Gửi tin nhắn thành công!',
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json($e->getMessage());
        }
    }


}