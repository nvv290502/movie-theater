<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillRequest extends FormRequest
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
            'billCode' => 'required',
            'userId' => 'required|exists:users,user_id',
            'movieId' => 'required|exists:movies,movie_id',
            'roomId' => 'required|exists:rooms,room_id',
            'showDate' => 'required|date_format:Y-m-d|after:today',
            'showTime' => 'required|date_format:H:i:s',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute la bat buoc',
            'exists' => ':attribute khong ton tai',
            'date_format' => ':attribute khong dung dinh dang'
        ];
    }

    public function attributes()
    {
        return [
            'billCode' => 'Ma hoa don',
            'userId' => 'Nguoi dung',
            'movieId' => 'Phim',
            'roomId' => 'Phong',
            'showDate' => 'Ngay chieu',
            'showTime' => 'Gio chieu'
        ];
    }
}
