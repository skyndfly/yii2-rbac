<?php

namespace app\services;

use app\services\contracts\PaginateUsersServiceContract;
use app\repositories\UserRepository;
use Yii;

class PaginateUsersService implements PaginateUsersServiceContract
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function execute()
    {

        echo "<pre>";
        print_r(111);
        echo "</pre>";
        die;

    }
}