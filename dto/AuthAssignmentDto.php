<?php

namespace app\dto;

class AuthAssignmentDto
{
    public function __construct(
        public string $itemName,
        public string $createdAt,
        public ?UserDto $user,
    )
    {
    }
}