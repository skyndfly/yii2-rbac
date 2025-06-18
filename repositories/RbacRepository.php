<?php

namespace app\repositories;

use app\dto\AuthItemDto;
use app\enums\RoleTypeEnum;

class RbacRepository extends BaseRepository
{
    public const AUTH_ITEM_TABLE = 'auth_item';

    /**
     * @return AuthItemDto[]
     */
    public function getAllRole():array
    {

        $rows = $this->getQuery()
            ->from(self::AUTH_ITEM_TABLE)
            ->where(['type' => RoleTypeEnum::ROLE->value])
            ->all();

        return array_map(
            fn($item) => $this->mapToAuthItemDto($item),
            $rows
        );

    }

    private function mapToAuthItemDto(array $data): AuthItemDto
    {

        return new AuthItemDto(
            $data['name'],
            $data['description'],
           RoleTypeEnum::from($data['type']),
        );

    }
}