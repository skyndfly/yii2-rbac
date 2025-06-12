<?php

namespace app\services\user\contracts;


use app\dto\PaginateUserDto;

interface PaginateUsersServiceContract
{
    /**
     * @return PaginateUserDto[]
     */
    public function execute(): array;
}