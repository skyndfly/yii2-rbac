<?php

declare(strict_types=1);

namespace app\widgets\form;


use app\dto\AuthItemDto;
use Yii;
use yii\base\Model;

class UserCreateForm extends Model
{
    public string $username = '';
    public string $password = '';
    public string $password_repeat = '';
    public ?string $role = '';


    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            [['password'], 'string', 'min' => 6],
            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Пароли не совпадают"],
            ['role', 'in', 'range' => array_keys(self::availableRoles())],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
            'role' => 'Роль пользователя',
        ];
    }

    public static function availableRoles(): array
    {
        /** @var AuthItemDto[] $roles */
        $roles = Yii::$app->getAuthManager()->getRoles();
        return array_map(
            fn($role) => "{$role->name} - " . ($role->description ?: 'Без описания'),
            $roles);
    }
}