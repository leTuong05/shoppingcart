<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginValidator extends FormRequest
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
            'email' => 'email|required',
            'password' => 'required|min:6'
        ];
    }

    public function message()
    {
        return [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email của bạn không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khấu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự'
        ];
    }
}
