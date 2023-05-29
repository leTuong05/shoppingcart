<?php

namespace App\Http\Requests\Shopping;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserValidator extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'phone_number' => ['required', 'min:10'],
            'avatar' => ['mimes:png,jpg']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Hãy nhập tên đầy đủ của bạn',
            'phone_number.required' => 'Hãy nhập số điện thoại của bạn',
            'phone_number.min' => 'Số điện thoại phải có ít nhất 10 số',
            'avatar.mimes' => 'Ảnh upload phải có định dạng png, jpg'
        ];
    }
}
