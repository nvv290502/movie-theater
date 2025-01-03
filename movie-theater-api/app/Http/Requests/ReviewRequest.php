<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'numberStar' => 'required|max:5',
            'movieId' => 'required|exists:movies,movie_id',
            'userId' => 'required|exists:users,user_id'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute la bat buoc',
            'max' => ':attribute sao khong hop le',
            'exists' => ':attributes khong ton tai'
        ];
    }

    public function attributes()
    {
        return [
            'numerStar' => 'So sao',
            'movieId' => 'Phim',
            'userId' => 'Mguoi dung'
        ];
    }
}
