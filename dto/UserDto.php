<?php

namespace app\dto;

class UserDto
{
    public function __construct(
        public int $id,
        public string $username,
        public string $status,
        public ?string $createdAt = null,
        public ?string $passwordHash = null,
        public ?string $accessToken = null,
        public ?string $authKey = null,
    ) {
    }
}