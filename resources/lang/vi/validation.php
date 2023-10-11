<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'after' => 'Trường :attribute phải sau ngày :date.',
    'before' => 'Trường :attribute phải trước ngày :date.',
    'between' => [
        'array' => 'Trường :attribute phải có từ :min đến :max vật phẩm.',
        'file' => 'Trường :attribute phải có từ :min đến :max KB.',
        'numeric' => 'Trường :attribute phải có từ :min đến :max.',
        'string' => 'Trường :attribute phải có từ :min đến :max ký tự.',
    ],
    'boolean' => 'Trường :attribute chỉ có giá trị đúng hoặc sai.',
    'confirmed' => 'Trường :attribute nhập lại không đúng.',
    'current_password' => 'Mật khẩu nhập lại không đúng.',
    'date' => 'Trường :attribute không phải là ngày hợp lệ.',
    'date_format' => 'Trường :attribute không đúng định dạng :format.',
    'email' => 'Trường :attribute phải có định dạng là email.',
    'exists' => 'Giá trị :attribute đã tồn tại.',
    'file' => 'Trường :attribute phải là một file.',
    'image' => 'Trường :attribute phải là hình ảnh.', 
    'integer' => 'Trường :attribute phải là số thực.',
    'json' => 'Trường :attribute phải là định dạng JSON.',
    'max' => [
        'array' => 'Trường :attribute giá trị không được lớn hơn :max',
        'file' => 'Trường :attribute không được lớn hơn :max KB.',
        'numeric' => 'Trường :attribute không được lớn hơn :max.',
        'string' => 'Trường :attribute không được lớn hơn :max ký tự.',
    ],
    'mimes' => 'Trường :attribute phải là file type: :values.',
    'min' => [
        'array' => 'Trường :attribute phải ít hơn :min phần tử.',
        'file' => 'Trường :attribute phải ít hơn :min KB.',
        'numeric' => 'Trường :attribute phải ít hơn :min.',
        'string' => 'Trường :attribute phải ít hơn :min ký tự.',
    ],
    'not_regex' => 'Trường :attribute có định dạng không hợp lệ.',
    'numeric' => 'Trường :attribute phải là số.',
    'password' => [
        'letters' => 'Trường :attribute phải chứa ít nhất một chữ cái.',
        'mixed' => 'Trường :attribute phải chứa ít nhất một chữ hoa và một chữ thường.',
        'numbers' => 'Trường :attribute phải chứa ít nhất một số.',
        'symbols' => 'Trường :attribute phải chứa ít nhất một ký tự đặc biệt.',      
    ],
    'regex' => 'Trường :attribute định dạng không hợp lệ.',
    'required' => 'Trường :attribute là bắt buộc.', 
    'same' => 'Trường :attribute và :other không giống nhau.',
    'size' => [
        'array' => 'Trường :attribute phải chứa :size phần tử.',
        'file' => 'Trường :attribute phải :size KB.',
        'numeric' => 'Trường :attribute phải :size.',
        'string' => 'Trường :attribute phải :size ký tự.',
    ], 
    'string' => 'Trường :attribute phải là chuỗi.',
    'unique' => ':attribute đã tồn tại.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
