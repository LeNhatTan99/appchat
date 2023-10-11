<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        return [
            'name' => 'required|max:255',
            'expired_at' => 'nullable|after:today',
            'stock' => 'required|numeric|min:0|max:10000',
            'price' => 'required|numeric|min:0',
            'avatar' => 'mimes:jpeg,jpg,png|max:3072',
            'category_id' => 'required|exists:categories,id',
            'sku' =>'required|min:10|max:20|regex:/^[a-zA-Z0-9\s]+$/|unique:products,sku,'.$this->product->id,
        ];
    }

}
