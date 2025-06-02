<?php

namespace app\dto;

class UserDto
{
    public int $id;
    public string $username;
    public string $passwordHash;
    public string $status;
    public ?string $authKey;
    public ?string $accessToken;
    public string $createdAt;
}