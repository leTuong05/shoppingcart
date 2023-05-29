<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactValidator extends FormRequest
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
            'name' => 'required',
            'phonenumber' => 'required',
            'fax' => 'required',
            'address' => 'required',
            'email' => 'required|email:rfc,dns',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường tên doanh nghiệp không được để trống!',
            'phonenumber.required' => 'Trường số điện thoại không được để trống!',
            'fax.required' => 'Trường số fax không được để trống!',
            'address.required' => 'Trường địa chỉ không được để trống!',
            'email.required' => 'Trường email không được để trống!',
        ];
    }
}
