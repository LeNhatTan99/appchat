<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'message' => 'required|max:255',
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
            'message.required' => 'Vui lòng nhập tin nhắn!',
            'message.max' => 'Vui lòng nhập tin nhắn tối đa 255 ký tự!',
        );
        return $messages;
    }
}
