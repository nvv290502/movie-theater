<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username'=>'required|max:50|unique:users,username',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required',
            'email'=>'required|email|unique:users,email'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Ten dang nhap khong duoc de trong',
            'username.max:50' => 'Ten dang nhap khong duoc vuot qua 50 ky tu',
            'username.unique' => 'Ten dang nhap da ton tai',
            'password.required' => 'Mat khau khong duoc de trong',
            'password.confirmed' => 'Mat khau khong trung khop',
            'password_confirmation.required' => 'Mat khau khong duoc de trong',
            'email.required' => 'Email khong duoc de trong',
            'email.email' => 'Email khong dung dinh dang',
            'email.unique' => 'Email da ton tai', 
        ];
    }
}
