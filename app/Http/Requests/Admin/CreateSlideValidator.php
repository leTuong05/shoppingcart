<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateSlideValidator extends FormRequest
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
            'image' => 'required',
            'image.*' => 'image'
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'Hãy upload ít nhất 1 ảnh',
            'image.*.image' => 'Slide upload phải có đuôi jpg, jpeg, png, bmp, gif, svg, hoặc webp'
        ];
    }
}
