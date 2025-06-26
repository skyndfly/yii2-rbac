<?php

namespace app\repositories;

use app\dto\AuthAssignmentDto;
use app\dto\UserDto;

class AuthAssignmentRepository extends BaseRepository
{
    /**
     * @return AuthAssignmentDto[]
     */
    public function getByName(string $name): array
    {
        $rows = $this->getQuery()
            ->select('as.item_name, as.created_at, u.id, u.username, u.status')
            ->from('auth_assignment as')
            ->where(['item_name' => $name])
            ->innerJoin('users u', 'u.id = as.user_id')
            ->all();
        return array_map(
            fn($item) => $this->mapToDto($item),
            $rows
        );

    }

    private function mapToDto(array $data)
    {
        return new AuthAssignmentDto(
            $data['item_name'],
            $data['created_at'],
            new UserDto(
                id: $data['id'],
                username: $data['username'],
                status: $data['status']
            )
        );
    }
}