<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:50',
            'postcode' => 'required|string|max:10',
            'address'  => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'icon'     => 'required|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            // 名前
            'username.required' => '名前を入力してください',
            'username.max'      => '名前は50文字以内で入力してください',

            // 郵便番号
            'postcode.required' => '郵便番号を入力してください',
            'postcode.max'      => '郵便番号は10文字以内で入力してください',

            // 住所
            'address.required'  => '住所を入力してください',
            'address.max'       => '住所は255文字以内で入力してください',

            // 建物名
            'building.required' => '建物名を入力してください',
            'building.max'      => '建物名は255文字以内で入力してください',

            // アイコン
            'icon.required'     => 'アイコンを一つ以上選択してください',
            'icon.image'        => 'アイコンは画像ファイルを選択してください',
            'icon.max'          => 'アイコンは2MB以内でアップロードしてください',
        ];
    }
}
