<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FetchRequest extends FormRequest
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
            'size' => 'numeric|min:0',
            'date' => 'date_format:Y-m-d'
        ];
    }

    public function messages()
    {
        return [
            'size.numeric' => 'size phai la mot so nguyen',
            'size.min' => 'size phai lon hon 0',
            'date.date_format' => 'ngay khong hop le'
        ];
    }
}
