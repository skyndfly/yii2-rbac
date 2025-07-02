<?php

namespace app\dto;

class RegisterUserDto
{
    public function __construct(
        public string $username,
        public string $password,
    ) {
    }

}