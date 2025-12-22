<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'address' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'size:8', 'regex:/^[0-9]{3}-[0-9]{4}$/'],
        ];
    }

    public function messages()
    {
        return [
            'address.required' => '住所を入力してください',
            'address.string' => '住所は文字で入力してください',
            'address.max' => '住所は255文字以内で入力してください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.size' => '郵便番号はハイフンを含めた8文字で入力してください',
            'postal_code.regex' => '郵便番号は000-0000の形式で入力してください',
        ];
    }
}
