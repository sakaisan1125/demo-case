<?php

return [
    'required' => ':attributeを入力してください',
    'email' => ':attributeはメール形式で入力してください',
    'min' => [
        'string' => ':attributeは:min文字以上で入力してください',
    ],
    'max' => [
        'string' => ':attributeは:max文字以内で入力してください',
    ],
    'confirmed' => ':attributeと一致しません',        // 🔧 修正
    'unique' => 'この:attributeは既に登録されています',        // 🔧 追加

    'attributes' => [
        'name' => 'ユーザー名',                              // 🔧 追加
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => '確認用パスワード',         // 🔧 追加
    ],
];