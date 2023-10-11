<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Support\Carbon;

class CreateUserRequest extends FormRequest
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
        return  [
            'user_name' => ['required', 'string', 'max:255', 'unique:users'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
            'province_id' => ['required'],
            'district_id' => ['required'],
            'commune_id' => ['required'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'birthday' => [
                'date',
                'before:' . Carbon::now()->subYears(18)->format('Y-m-d')
            ],
            'avatar' => 'required|mimes:jpeg,jpg,png|max:3072',
            'status' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
