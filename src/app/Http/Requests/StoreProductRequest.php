<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'categories'   => 'required|array',
            'categories.*' => 'exists:categories,id',
            'condition_id' => 'required|exists:conditions,id',
            'name'         => 'required|string|max:255',
            'brand'        => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|integer|min:0',
            'images'       => 'required|array',
            'images.*'     => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'categories.required'   => 'カテゴリを1つ以上選択してください。',
            'categories.array'      => 'カテゴリの形式が不正です。',
            'categories.*.exists'   => '選択したカテゴリが無効です。',
            'condition_id.required' => '商品の状態を選択してください。',
            'condition_id.exists'   => '選択した商品の状態が無効です。',
            'name.required'         => '商品名は必須です。',
            'name.max'              => '商品名は255文字以内で入力してください。',
            'brand.max'             => 'ブランド名は255文字以内で入力してください。',
            'price.required'        => '販売価格を入力してください。',
            'price.integer'         => '販売価格は整数で入力してください。',
            'price.min'             => '販売価格は0円以上で入力してください。',
            'images.required'       => '商品画像を1枚以上アップロードしてください。',
            'images.*.image'        => 'アップロードできるのは画像ファイルのみです。',
            'images.*.mimes'        => '画像はjpeg, png, jpg, gif形式でアップロードしてください。',
            'images.*.max'          => '画像は2MB以内にしてください。',
        ];
    }
}
