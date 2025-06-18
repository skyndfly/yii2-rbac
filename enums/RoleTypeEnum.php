<?php

namespace app\enums;

enum RoleTypeEnum:int
{
    case ROLE = 1;
    case PERMISSION = 2;

    public function label(): string
    {
        return match ($this) {
            self::ROLE => 'Роль',
            self::PERMISSION => 'Разрешение',
        };
    }
}
