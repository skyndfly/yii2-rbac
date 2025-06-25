<?php

namespace app\dto;

use app\enums\RoleTypeEnum;

class AuthItemDto
{
    public function __construct(
        public string $name,
        public string $description,
        public RoleTypeEnum $type,
        public int $countRelated = 0,
    ) {
    }
}