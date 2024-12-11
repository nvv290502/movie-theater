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
            'movieId' => 'required',
            'userId' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'numberStar.required' => 'Vui long chon so sao',
            'numberStar.max' => 'So sao khong hop le',
            'movieId.required' => 'Phim khong duoc de trong',
            'userId.required' => 'Nguoi dung khong duoc de trong'
        ];
    }
}
