<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /**
     *  login with account
     *
     * @param Request $request
     *
     * @return JsonResponse
     */

    public function login(Request $request)
    {
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::guard('admin')->attempt($arr)) {
            $admin = Auth::guard('admin')->user();
            $token = $admin->createToken('admin token', ['admin'])->accessToken;
            return response()->json(
                [
                    'token' => $token,
                    'token_type' => 'bearer',
                    'account' => $admin,
                    'type' => 'admin',
                    'message' => 'Xin chào Admin'. ' ' . $admin->email,
                ],
                Response::HTTP_OK
            );
        } elseif (Auth::guard('web')->attempt($arr)) {
            $user = Auth::guard('web')->user();
            $token = $user->createToken('user token', ['user'])->accessToken;
            return response()->json(
                [
                    'token' => $token,
                    'token_type' => 'bearer',
                    'account' => $user,
                    'type' => 'user',
                    'message' => 'Xin chào'. ' ' . $user->email,
                ],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                [
                    'message' => 'Đăng nhập thất bại, vui lòng kiểm tra thông tin đăng nhập!'
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check() || Auth::guard('api')->check()) {
            $user = Auth::guard('admin')->user() ?: Auth::guard('api')->user();

            $user->tokens->each(function ($token, $key) {
                $token->delete();
            });
            return response()->json(
                ['message' => 'Đăng xuất thành công'],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                ['message' => 'Bạn chưa đăng nhập'],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }
    
     /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

        /**
     * Register a new user.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            $data = [
                'full_name' => $request->input('full_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ];
            $user = User::create($data);

            return response()->json([
                'message' => 'Đăng ký tài khoản thành công!', 
                'data' => $user,
                'code'=> Response::HTTP_CREATED
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'Có lỗi xảy ra, vui lòng thử lại!'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
