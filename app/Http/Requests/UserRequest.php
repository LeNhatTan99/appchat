<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $rules = [
            'email' => 'required|email|max:100|unique:users,email,' . $this->route('id'),
            'phone' => 'required|min:10|max:16|unique:users,phone,' . $this->route('id'),
            'birthday' => ['required','date_format:Y-m-d','before:18 years'],
            'full_name' => 'required|max:100',
            'password' => $this->route('id') ? 'nullable|min:3|max:150|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).*$/u' : 'required|min:3|max:150|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).*$/u',
            'address' => 'required|max:100',
            'province_id' => 'required|exists:provinces,id',
            'district_id' => 'required|exists:districts,id',
            'commune_id' => 'required|exists:communes,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        return $rules;
    }

      /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        $messages = array(
            'email.required' => 'Vui lòng nhập email!',
            'email.email' => 'Vui lòng nhập đúng định dạng email!',
            'email.max' => 'Vui lòng nhập email tối đa 10 ký tự!',
            'email.unique' => 'Email đã được sử dụng!',
            'birthday.required' => 'Vui lòng nhập ngày sinh!',
            'birthday.before' => 'Ngày sinh phải lớn hơn 18 tuổi!',  
            'birthday.date_format' => 'Vui lòng nhập ngày sinh đúng định dạng ngày/tháng/năm!',  
            'address.required' => 'Vui lòng nhập địa chỉ!',
            'address.max' => 'Vui lòng nhập địa chỉ lớn nhất 100 ký tự!',
            'phone.min' => 'Vui lòng nhập số điện thoại ít nhất 10 ký tự!',
            'phone.max' => 'Vui lòng nhập số điện thoại lớn nhất 16 ký tự!',
            'phone.unique' => 'Số điện thoại đã được sử dụng!',
            'phone.required' => 'Vui lòng nhập số điện thoại!',
            'full_name.required' => 'Vui lòng nhập họ và tên!',
            'avatar.image' => 'Avatar phải là hình ảnh!',
            'avatar.mimes' => 'Avatar phải là hình ảnh!',
            'password.regex' => 'Mật khẩu phải có ít nhất 1 chữ hoa, 1 số và 1 ký tự đặc biệt!',
            'password.required' => 'Vui lòng nhập mật khẩu!',
            'province_id.required' => 'Vui lòng chọn Tỉnh/Thành phố!',
            'province_id.exists' => 'Tỉnh/Thành phố không tồn tại!',
            'district_id.required' => 'Vui lòng chọn Quận/Huyện!',
            'district_id.exists' => 'Quận/Huyện không tồn tại!',
            'commune_id.required' => 'Vui lòng chọn Phường/Xã!',
            'commune_id.exists' => 'Phường/Xã không tồn tại!',
        );
        return $messages;
    }
}
