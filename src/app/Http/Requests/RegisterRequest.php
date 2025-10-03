<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'username' => '名前',
            'email'    => 'メールアドレス',
            'password' => 'パスワード',
            'password_confirmation' => '確認用パスワード',
        ];
    }

    public function rules()
    {
        return [
            'username' => 'required|string|max:50',
            'email'    => 'required|string|email|max:50|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            // 名前
            'username.required' => '名前を入力してください',
            'username.max'      => '名前は50文字以内で入力してください',

            // メールアドレス
            'email.required' => 'メールアドレスを入力してください',
            'email.email'    => '正しいメールアドレス形式で入力してください',
            'email.max'      => 'メールアドレスは50文字以内で入力してください',
            'email.unique'   => 'このメールアドレスはすでに登録されています',

            // パスワード
            'password.required'  => 'パスワードを入力してください',
            'password.min'       => 'パスワードは8文字以上で入力してください',
            'password.confirmed' => 'パスワードと一致しません',
        ];
    }
}
