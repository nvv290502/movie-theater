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
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên phim là bắt buộc.',
            'name.max' => 'Tên phim không được vượt quá 255 ký tự.',
            'duration.required' => 'Thời lượng là bắt buộc.',
            'duration.numeric' => 'Thời lượng phải là một số.',
            'duration.min' => 'Thời lượng phải lớn hơn hoặc bằng 1.',
            'releaseDate.required' => 'Ngày phát hành là bắt buộc.',
            'releaseDate.date' => 'Ngày phát hành phải là định dạng ngày hợp lệ.',
            'author.required' => 'Tác giả là bắt buộc.',
            'actor.required' => 'Diễn viên là bắt buộc.',
            'trailer.required' => 'Trailer là bắt buộc.',
            'summary.required' => 'Tóm tắt nội dung là bắt buộc.',
            'language.required' => 'Language nội dung là bắt buộc.',
        ];
    }
}
