<?php

namespace app\repositories;

use app\dto\AuthItemDto;
use app\enums\RoleTypeEnum;
use Yii;

class AuthItemRepository extends BaseRepository
{
    public const AUTH_ITEM_TABLE = 'auth_item';

    /**
     * @return AuthItemDto[]
     */
    public function getAllRole(): array
    {
        $rows = $this->getQuery()
            ->from(self::AUTH_ITEM_TABLE)
            ->where(['type' => RoleTypeEnum::ROLE->value])
            ->all();

        return array_map(
            fn($item) => $this->mapToDto($item),
            $rows
        );

    }

    public function store(AuthItemDto $dto): void
    {
        $authManager = Yii::$app->getAuthManager();
        if ($dto->type === RoleTypeEnum::ROLE) {
            $role = $authManager->createRole($dto->name);
        } else {
            $role = $authManager->createPermission($dto->name);
        }
        $role->description = $dto->description;
        $authManager->add($role);
    }

    public function countRelated(string $name): int
    {
        return $this->getQuery()
            ->from('auth_item ai')
            ->where(['name' => $name])
            ->innerJoin('auth_assignment aa', 'aa.item_name = ai.name')
            ->count();
    }

    private function mapToDto(array $data): AuthItemDto
    {

        return new AuthItemDto(
            $data['name'],
            $data['description'],
            RoleTypeEnum::from($data['type']),
        );
    }
}