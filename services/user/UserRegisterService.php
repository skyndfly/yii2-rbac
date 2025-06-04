<?php

namespace app\services\user;

use app\auth\UserIdentity;
use app\dto\RegisterUserDto;
use app\repositories\UserRepository;
use app\services\user\contracts\UserRegisterServiceContract;
use Yii;

class UserRegisterService implements UserRegisterServiceContract
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(RegisterUserDto $dto): void
    {
        $user = $this->userRepository->save($dto);
        $user = new UserIdentity($user);
        Yii::$app->user->login($user, 3600 * 24 * 30);
    }
}