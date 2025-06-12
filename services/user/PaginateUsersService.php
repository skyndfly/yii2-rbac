<?php

namespace app\services\user;

use app\dto\PaginateUserDto;
use app\dto\RoleDto;
use app\dto\UserDto;
use app\repositories\UserRepository;
use app\services\user\contracts\PaginateUsersServiceContract;
use Yii;

class PaginateUsersService implements PaginateUsersServiceContract
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return PaginateUserDto[]
     */
    public function execute(): array
    {
        $usersDto = $this->userRepository->getAllActiveUsers();

        $auth = Yii::$app->authManager;
        $users = [];
        foreach ($usersDto as $user) {
            $roles = array_map(
                fn ($role) => new RoleDto(
                    $role->type,
                    $role->name,
                    $role->description,
                    $role->ruleName,
                    $role->createdAt,
                    $role->updatedAt,
                ),
                $auth->getRolesByUser($user->id)
            );

            $users[] = new PaginateUserDto($user, $roles);
        }
        return $users;
    }
}