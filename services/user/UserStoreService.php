<?php

namespace app\services\user;

use app\auth\UserIdentity;
use app\dto\RegisterUserDto;
use app\repositories\UserRepository;
use Yii;

class UserStoreService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function execute(RegisterUserDto $userDto, UserIdentity $admin, string $roleName)
    {
        $user = $this->userRepository->save($userDto);
        $auth = Yii::$app->getAuthManager();
        $role = $auth->getRole($roleName);
        $auth->assign($role, $user->id);
    }
}