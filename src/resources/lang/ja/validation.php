<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'failed' => '認証情報が記録と一致しません。',
    'password' => 'パスワードが正しくありません。',
    'accepted' => ':attribute を承認してください。',
    'active_url' => ':attribute は有効なURLではありません。',
    'after' => ':attribute には :date より後の日付を指定してください。',
    'after_or_equal' => ':attribute には :date 以降の日付を指定してください。',
    'alpha' => ':attribute はアルファベットのみ使用できます。',
    'alpha_dash' => ':attribute は英数字、ハイフン、アンダースコアのみ使用できます。',
    'alpha_num' => ':attribute は英数字のみ使用できます。',
    'array' => ':attribute は配列でなければなりません。',
    'before' => ':attribute には :date より前の日付を指定してください。',
    'before_or_equal' => ':attribute には :date 以前の日付を指定してください。',

    // --- よく使うもの ---
    'required' => ':attribute は必須です。',
    'email'    => '正しいメールアドレス形式で入力してください。',
    'min'      => [
        'string' => ':attribute は :min 文字以上で入力してください。',
    ],
    'max'      => [
        'string' => ':attribute は :max 文字以内で入力してください。',
    ],
    'confirmed' => ':attribute が確認欄と一致しません。',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'email' => 'メールアドレス',
        'password' => 'パスワード',
    ],

];
