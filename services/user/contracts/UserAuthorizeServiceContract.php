<?php

namespace app\services\user\contracts;

use app\dto\AuthorizeUserDto;

interface UserAuthorizeServiceContract
{
    public function execute(AuthorizeUserDto $dto): bool;
}