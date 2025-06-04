<?php

namespace app\services\user;

use app\auth\UserIdentity;
use app\dto\AuthorizeUserDto;
use app\repositories\UserRepository;
use app\services\user\contracts\UserAuthorizeServiceContract;
use DomainException;
use Yii;

class UserAuthorizeService implements UserAuthorizeServiceContract
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(AuthorizeUserDto $dto): bool
    {
        $user = $this->getUser($dto->username);
        if (!$user || !$user->validatePassword($dto->password)) {
            throw new DomainException('Логин или пароль не правильный');
        }
        return Yii::$app->user->login($user, $dto->rememberMe ? 3600*24*30 : 0);
    }

    private function getUser(string $username): ?UserIdentity
    {
        $user = $this->userRepository->findByUserName($username);
        return $user === null ? null : new UserIdentity($user);
    }
}