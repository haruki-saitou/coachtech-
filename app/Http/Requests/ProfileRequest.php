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
            'image_path' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048'],
            'name' => ['required', 'string', 'max:20'],
            'post_code' => ['nullable', 'string', 'size:8', 'regex:/^[0-9]{3}-[0-9]{4}$/'],
            'address' => ['nullable', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'image_path.mimes' => 'jpeg,png形式の画像を選択してください',
            'image_path.max' => '画像は2MB以内で選択してください',
            'name.required' => 'お名前を入力してください',
            'name.string' => 'お名前は文字で入力してください',
            'name.max' => 'お名前は20文字以内で入力してください',
            'post_code.string' => '郵便番号は文字で入力してください',
            'post_code.size' => '郵便番号はハイフンを含めた8文字で入力してください',
            'post_code.regex' => '郵便番号は000-0000の形式で入力してください',
            'address.string' => '住所は文字で入力してください',
            'address.max' => '住所は255文字以内で入力してください',
            'building.string' => '建物名は文字で入力してください',
            'building.max' => '建物名は255文字以内で入力してください',
        ];
    }
}
