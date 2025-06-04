<?php

namespace app\services\user\contracts;

use app\dto\RegisterUserDto;

interface UserRegisterServiceContract
{
    public function execute(RegisterUserDto $dto);
}