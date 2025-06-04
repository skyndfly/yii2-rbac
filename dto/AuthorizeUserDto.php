<?php

namespace app\dto;

class AuthorizeUserDto
{
    public string $username;
    public string $password;
    public bool $rememberMe;

    public function __construct(string $username, string $password, bool $rememberMe)
    {
        $this->username = $username;
        $this->password = $password;
        $this->rememberMe = $rememberMe;
    }

}