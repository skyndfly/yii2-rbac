<?php

namespace app\widgets\form;

use yii\base\Model;


class LoginForm extends Model
{
    public string $username = '';
    public string $password = '';
    public bool $rememberMe = true;



    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean']
        ];
    }

    public function attributeLabels():array
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня'
        ];
    }


}
