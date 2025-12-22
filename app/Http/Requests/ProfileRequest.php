<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048'],
            'name' => ['required', 'string', 'max:20'],
            'postal_code' => ['required', 'string', 'size:8', 'regex:/^[0-9]{3}-[0-9]{4}$/'],
            'address' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'profile_image.mimes' => 'jpeg,png形式の画像を選択してください',
            'profile_image.max' => '画像は2MB以内で選択してください',
            'name.required' => '名前を入力してください',
            'name.string' => '名前は文字で入力してください',
            'name.max' => '名前は20文字以内で入力してください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.size' => '郵便番号はハイフンを含めた8文字で入力してください',
            'postal_code.regex' => '郵便番号は000-0000の形式で入力してください',
            'address.required' => '住所を入力してください',
            'address.string' => '住所は文字で入力してください',
            'address.max' => '住所は255文字以内で入力してください',
        ];
    }
}