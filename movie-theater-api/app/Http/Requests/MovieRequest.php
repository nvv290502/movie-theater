<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'duration' => 'required|numeric|min:1',
            'releaseDate' => 'required|date',
            'author' => 'required',
            'actor' => 'required',
            'trailer' => 'required',
            'summary' => 'required',
            'language' => 'required',
            'poster' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'banner' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute là bắt buộc.',
            'max' => ':attribute vuot qua kich thuoc.',
            'numeric' => ':attribute phải là một số.',
            'min' => ':attribute phải lớn hơn hoặc bằng 1.',
            'date' => ':attribute phải là định dạng ngày hợp lệ.',
            'file' => ':attribute phai la dang file.',
            'mimes'=> ':attribute phai co duoi jpeg,png,jpg.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Ten phim',
            'duration' => 'Thoi luong',
            'releaseDate' => 'Ngay phat hanh',
            'author' => 'Tac gia',
            'actor' => 'Dien vien',
            'trailer' => 'Trailer',
            'summary' => 'Tom tat',
            'language' => 'Ngon ngu',
            'poster' => 'Poster',
            'banner' => 'Banner'
        ];
    }
}
