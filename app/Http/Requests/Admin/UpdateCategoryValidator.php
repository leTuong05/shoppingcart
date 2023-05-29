<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryValidator extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('categories', 'name')->ignore($this->id)
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường tên danh mục không được để trống!',
            'name.unique' => 'Danh mục này đã tồn tại, hãy chọn một cái tên khác!',
        ];
    }
}
