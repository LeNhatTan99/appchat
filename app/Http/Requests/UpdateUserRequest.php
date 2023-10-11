<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
      
        return 
            [
               'user_name' => 'required|string| max:255|unique:users,email,'.$this->user->id,
               'first_name' => ['required', 'string', 'max:50'],
               'last_name' => ['required', 'string', 'max:50'],
               'province_id' => ['required'],
               'district_id' => ['required'],
               'commune_id' => ['required'],
               'last_name' => ['required', 'string', 'max:50'],
               'email' => 'required| string| email| max:100| unique:users,email,'.$this->user->id,
               'birthday' => [
                'date',
                'before:' . Carbon::now()->subYears(18)->format('Y-m-d')
                ],
               'avatar' => 'mimes:jpeg,jpg,png|max:3072',
               'status' => ['required', 'string', 'max:100'],
               'password' => ['required', 'string', 'min:8'],
           ];               
    }
}
