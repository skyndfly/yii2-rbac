<?php

namespace app\dto;

class PaginateUserDto
{
    public UserDto $userDto;
    /** @var RoleDto[] $roles */
    public ?array $roles = null;

    /**
     * @param RoleDto[] $roles
     */
    public function __construct(UserDto $userDto, ?array $roles)
    {
        $this->userDto = $userDto;
        $this->roles = $roles;
    }
}