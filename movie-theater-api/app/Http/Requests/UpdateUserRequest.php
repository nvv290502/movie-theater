<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('id');
    
        return [
            'date_of_birth' => 'date|nullable',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId, 'user_id')
            ],
            'phone' => [
                'required',
                'regex:/^0\d{9}$/',
                Rule::unique('users', 'phone')->ignore($userId, 'user_id')
            ],
        ];
    }
    

    public function messages()
    {
        return [
            'date_of_birth.date' => 'Ngay sinh khong dung dinh dang',
            'email.required' => 'Email khong duoc de trong',
            'email.email' => 'Email khong dung dinh dang',
            'email.unique' => 'Email da ton tai',
            'phone.unique' => 'So dien thoai da ton tai',
            'phone.regex' => 'So dien thoai khong hop le'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        throw new HttpResponseException(
            response()->json([
                'status' => 422,
                'message' => 'Loi du lieu input',
                'errors' => $errors
            ], 422)
        );
    }
}
