<?php

namespace app\widgets\form;

use yii\base\Model;

class RegisterForm extends Model
{
    public string $username = '';
    public string $password = '';
    public string $password_repeat = '';

    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            [['password'], 'string', 'min' => 6],
            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Пароли не совпадают"],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
        ];
    }
}