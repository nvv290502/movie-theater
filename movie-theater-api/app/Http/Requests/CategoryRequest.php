<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên thể loại không được để trống',
            'name.max' => 'Tên thể loại không được vượt quá 255 ký tự'
        ];
    }

    public function failedValidation(ValidationValidator $validator)
    {
        $errors = $validator->errors()->toArray();

        // Ném HttpResponseException để trả về lỗi dưới dạng JSON
        throw new HttpResponseException(
            response()->json([
                'status' => 422,
                'message' => 'Lỗi dữ liệu đầu vào',
                'errors' => $errors,
            ], 422)
        );
    }
}
