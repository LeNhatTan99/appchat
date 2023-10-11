<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Http\Requests\UserRequest;
use App\Services\UserFileService;


class UserController extends Controller
{
    /**
     *  __construct
     *
     * @param UserFileService $userFileService
     */
    public function __construct(UserFileService $userFileService)
    {
        $this->userFileService = $userFileService;
    }

       /**
     *  Show list user
     *
     * @return JsonResponse
     */
    public function index(Request $request) {
        try {
            $users = $this->userFileService->getUser($request);
            return response()->json([
                'users' => $users,
                'message' => 'Hiển thị danh sách tài khoản thành công!',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            return response()->json($e->getMessage());
        }
    }

        /**
     *  Create user
     *
     * @return JsonResponse
     */
    public function create(UserRequest $request) {
        try {
            $user = $this->userFileService->create($request);
            return response()->json([
                'user' => $user,
                'message' => 'Tạo tài khoản thành công!',
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            return response()->json($e->getMessage());
        }
    }


    /**
     *  Show info user
     *
     * @return JsonResponse
     */

     public function edit($id)
     {
         $data = $this->userFileService->edit($id);
         if($data) {
             return response()->json([
                 'data' => $data,
                 'message' => 'Hiển thị thông tin tài khoản thành công!',
             ], Response::HTTP_OK);
         }
            return response()->json([
                'error' => 'error',
                'message' => 'Tài khoản không tồn tại!',
            ], Response::HTTP_BAD_REQUEST);
     }


    /**
     *  Show info user
     *
     * @return JsonResponse
     */

     public function delete($id)
     {
         $data = $this->userFileService->delete($id);
         if($data) {
             return response()->json([
                 'data' => $data,
                 'message' => 'Xoá tài khoản thành công!',
             ], Response::HTTP_OK);
         }
            return response()->json([
                'error' => 'error',
                'message' => 'Tài khoản không tồn tại!',
            ], Response::HTTP_BAD_REQUEST);
     }

     public function searchUser(Request $request) {
        try {
            $users = $this->userFileService->searchUser($request);
            return response()->json([
                'users' => $users,
                'message' => 'Hiển thị danh sách tài khoản thành công!',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            return response()->json($e->getMessage());
        }
     }
     
      /**
     *  Update user
     *
     * @return JsonResponse
     */
    public function update($id, UserRequest $request) {
        try {
            $user = $this->userFileService->updateUser($id, $request);
            return response()->json([
                'user' => $user,
                'message' => 'Cập nhật tài khoản thành công!',
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            return response()->json($e->getMessage());
        }
    }
    /**
     *  Show info account login
     *
     * @return JsonResponse
     */

    public function info()
    {
        $data = $this->userFileService->info();
        return response()->json([
            'data' => $data,
            'message' => 'Hiển thị thông tin tài khoản thành công!',
        ], Response::HTTP_OK);
    }

    /**
     *  Update info account
     *
     * @param \Illuminate\Http\Request  $request 
     *
     * @return JsonResponse
     */
    public function updateInfo(UserRequest $request)
    {
        $account = $this->userFileService->update($request);
        if ($account) {
            return response()->json(
                [
                    'account update' => $account,
                    'message' => 'Cập nhật thông tin tài khoản thành công!'
                ],
                Response::HTTP_OK
            );
        } else {
            return response()->json([
                'error' => 'Cập nhật thông tin tài khảon thất bại!'
            ], Response::HTTP_NOT_FOUND);
        }
    }


}
