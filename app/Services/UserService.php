<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Jobs\SendMailToUser;

class UserService
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getUser(Request $request)
    {
        $searchWord = $request->search_word;
        $data = User::query();
        if ($request->has('search_word') && !is_null($searchWord)) {
            $data->when($searchWord, function ($query, $searchWord) {
                $query->where('full_name', 'like', "%{$searchWord}%")
                    ->orWhere('email', 'like', "%{$searchWord}%")
                    ->orWhere('first_name', 'like', "%{$searchWord}%")
                    ->orWhere('last_name', 'like', "%{$searchWord}%");
            });
        }
        $users = $data->select(
            'id',
            'full_name',
            'email',
            'birthday',
            'avatar',
            'province_id',
            'district_id',
            'commune_id',
            'address',
            'status',
            'flag_delete'
        )
            ->where('flag_delete', 0)->paginate(15);
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserRequest  $request
     * @return bool
     */
    public function store(CreateUserRequest $request)
    {
        if ($request->hasFile('avatar')) {
            $path = UserService::uploadImage($request);
            $data = [
                'user_name' => $request->user_name,
                'email' => $request->email,
                'birthday' => $request->birthday,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address' => $request->address,
                'province_id' => $request->province_id,
                'district_id' => $request->district_id,
                'commune_id' => $request->commune_id,
                'avatar' =>  substr($path, strlen('upload/user_images/')),
                'status' => $request->status,
                'password' => Hash::make($request['password']),
            ];
        } 
        DB::beginTransaction();
        try {
             User::create($data);
            $mails = [
                'email' => $request->email,
                'viewMail' => 'mails.user.mail_create_user',
                'subject' => 'Email registration successful'
            ];
            SendMailToUser::dispatch($mails);
            DB::commit();
            return  true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return  false;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  App\Model\User $user
     * @return bool
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = [
            'user_name' => $request->user_name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'commune_id' => $request->commune_id,
            'status' => $request->status,
            'password' => Hash::make($request['password']),
        ];
        if ($request->has('avatar')) {
            $path = UserService::uploadImage($request);
            $data['avatar'] = substr($path, strlen('upload/user_images/'));
        }
        DB::beginTransaction();
        try {
           $user = $user->update($data);
            $mails = [
                'email' => $request->email,
                'viewMail' => 'mails.user.mail_update_user',
                'subject' => 'Email registration successful'
            ];
            SendMailToUser::dispatch($mails);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Model\User $user
     */

    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            $user->update(array('flag_delete' => '1'));
            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return false;
        }
    }

    /**
     * create a path name when uploading pictures.
     *
     * @param  \Illuminate\Http\Request  $request
     */

    public function uploadImage($request)
    {
        $nameImage = $request->user_name . "." . $request->avatar->getClientOriginalExtension();
        $path = $request->file('avatar')->move('upload/user_images', 'avatar' . $nameImage);
        return $path;
    }
}
