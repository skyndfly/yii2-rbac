<?php

namespace app\auth;

use app\dto\UserDto;
use app\repositories\UserRepository;
use Yii;
use yii\web\IdentityInterface;

class UserIdentity implements IdentityInterface
{
    private UserDto $user;

    public function __construct(UserDto $user)
    {
        $this->user = $user;
    }

    public static function findIdentity($id)
    {
        $repo = new UserRepository();
        $user = $repo->findById($id);
        return $user ? new self($user) : null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return 1;
    }

    public function getId(): int
    {
        return $this->user->id;
    }

    public function getUserName(): string
    {
        return $this->user->username;
    }


    public function getAuthKey()
    {
        return $this->user->authKey;
    }


    public function validateAuthKey($authKey)
    {
        return $this->user->authKey === $authKey;
    }

    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->user->passwordHash);
    }
}