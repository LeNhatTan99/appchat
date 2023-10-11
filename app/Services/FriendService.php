<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\User;
use App\Models\UserConversation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\FriendShip;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class FriendService
{
    /**
     * add friend
     *
     * @return JsonResponse
     */
    public function addFriend($userId, $requestId)
    {
        try {
            DB::beginTransaction();          
            $user = User::select('id')->where('id', $requestId)->first();
            if($userId == $requestId || !$user) {
                return ['error' => 'Tài khoản không tồn tại!'];
            }
            $check = self::checkFriendship($userId, $requestId);
            if ($check == FriendShip::REJECT || $check === null) {
                $data = [
                    'user_id' => $requestId,
                    'friend_id' => $userId,
                    'status' => Friendship::PENDING,
                ];
                $data = Friendship::create($data);
            } elseif ($check == FriendShip::PENDING) {
                $data = ['error' => 'Gửi yêu cầu kết bạn trùng lặp.'];
            } elseif ($check == FriendShip::ACCEPTED) {
                $data = ['error' => 'Các bạn đã là bạn bè.'];
            } elseif ($check == FriendShip::BLOCK) {
                $data = ['error' => 'Bạn đã bị chặn.'];
            }
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return response()->json($e->getMessage());
        }
    }

    public function friendPending($userId) {
        try {
            $listFriendPending = Friendship::where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('friendships.status', Friendship::PENDING);
                })
                ->join('users', 'users.id', '=', 'friendships.friend_id')
                ->select(
                    DB::raw('friendships.id as friendship_id'),
                    'friendships.user_id',
                    'friendships.friend_id',
                    'users.avatar',
                    'users.email',
                    'users.phone',
                    'users.birthday',
                    'users.full_name',
                )
                ->get();
            return $listFriendPending;
        } catch (\Exception $e) {
            Log::error('[UserController][UserByService] error ' . $e->getMessage());
            throw new \Exception('[UserController][UserByService] error ' . $e->getMessage());
        }
    }

    public function acceptFriendship($id, $request) {
        $userId = auth('api')->user()->id;
        try {
            DB::beginTransaction(); 
            $friendship = Friendship::where('id', $id)
                            ->where('user_id', $userId)
                            ->where('status', FriendShip::PENDING)
                            ->first();
            if($friendship) {
                if($request->status == FriendShip::ACCEPTED) {
                    $friendship->update(['status' => FriendShip::ACCEPTED]);
                    $conversation = Conversation::create(['creator_id'=>$userId]);
                    UserConversation::create(['user_id' => $userId, 'conversation_id' => $conversation->id]);
                    UserConversation::create(['user_id' => $friendship->friend_id, 'conversation_id' => $conversation->id]);
                } else {
                    $friendship->update(['status' => FriendShip::REJECT]);
                }
            }
            DB::commit(); 
            return $friendship;
        } catch (\Exception $e) {
            DB::rollBack(); 
            Log::error('[UserController][UserByService] error ' . $e->getMessage());
            throw new \Exception('[UserController][UserByService] error ' . $e->getMessage());
        }
    }

    public function checkFriendship($userId, $friendId)
    {
        $check = Friendship::where(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $userId)
                ->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $friendId)
                ->where('friend_id', $userId);
        })->first();
        if ($check) {
            switch ($check->status) {
                case FriendShip::REJECT:
                    return FriendShip::REJECT;
                case FriendShip::PENDING:
                    return FriendShip::PENDING;
                case FriendShip::ACCEPTED:
                    return FriendShip::ACCEPTED;
                case FriendShip::BLOCK:
                    return FriendShip::BLOCK;
                default:
                    return $check;
            }
        }
        return null;
    }
}