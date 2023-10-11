<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\FriendService;

class FriendController extends Controller
{
    /**
     *  __construct
     *
     * @param FriendService $friendService
     */
    public function __construct(FriendService $friendService)
    {
        $this->friendService = $friendService;
    }

    /**
     * add friend
     *
     * @return JsonResponse
     */

    public function addFriend($id)
    {
        try {
            $userId = auth('api')->user()->id;
            $requestId = $id;

            $data = $this->friendService->addFriend($userId, $requestId);
            if($data['error']) {
                return response()->json([
                    'error' => $data['error'],
                ], Response::HTTP_FORBIDDEN);
            }
            return response()->json([
                'data' => $data,
                'message' => 'Gửi yêu cầu kết bạn thành công!',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            return response()->json($e->getMessage());
        }       
    }

     /**
     * add friend
     *
     * @return JsonResponse
     */

     public function friendPending()
     {
         try {
             $userId = auth('api')->user()->id;
             $data = $this->friendService->friendPending($userId);
             $pendingCount = $data->count();
             return response()->json([
                 'data' => $data,
                 'count' => $pendingCount,
                 'message' => 'Gửi yêu cầu kết bạn thành công!',
             ], Response::HTTP_OK);
         } catch (\Exception $e) {
             \Log::error( $e->getMessage() );
             return response()->json($e->getMessage());
         }          
     }

     public function acceptFriendship($id, Request $request) {
        try {
            $data = $this->friendService->acceptFriendship($id, $request);
            if($data) {
                if($data->status == Friendship::ACCEPTED) {
                    return response()->json([
                        'data' => $data,
                        'message' => 'Chấp nhận kết bạn thành công!',
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'data' => $data,
                        'message' => 'Từ chối kết bạn thành công!',
                    ], Response::HTTP_OK);
                }
            }
            return response()->json([
                'error' => 'Yêu cầu kết bạn không tồn tại!',
            ], Response::HTTP_FORBIDDEN);
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            return response()->json($e->getMessage());
        }  
     }
}
