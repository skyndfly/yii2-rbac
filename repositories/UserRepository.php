<?php

namespace app\repositories;

use app\dto\RegisterUserDto;
use app\dto\UserDto;
use app\enums\UserStatusEnum;
use Yii;

class UserRepository extends BaseRepository
{
    public const TABLE = "users";

    public function findById(int $id): ?UserDto
    {
        $row = $this->getQuery()
            ->where(['id' => $id])
            ->andWhere(['status' => UserStatusEnum::ACTIVE])
            ->from(self::TABLE)
            ->one();
        return $row ? $this->mapToDto($row) : null;

    }

    final public function findByUserName(string $username): ?UserDto
    {
        $row = $this->getQuery()
            ->where(['username' => $username])
            ->andWhere(['status' => UserStatusEnum::ACTIVE])
            ->from(self::TABLE)
            ->one();
        return $row ? $this->mapToDto($row) : null;
    }

    public function save(RegisterUserDto $dto): ?UserDto
    {
        $passwordHash = Yii::$app->getSecurity()->generatePasswordHash($dto->password);
        $authKey = Yii::$app->getSecurity()->generateRandomString();
        $accessToken = Yii::$app->getSecurity()->generateRandomString();

        $this->getCommand()
            ->insert(self::TABLE,
            [
                'username' => $dto->username,
                'password_hash' => $passwordHash,
                'auth_key' => $authKey,
                'access_token' => $accessToken,
                'status' => UserStatusEnum::ACTIVE,
            ])
            ->execute();

        return $this->findById(Yii::$app->db->getLastInsertID());
    }

    /**
     * @return UserDto[]
     */
    public function getAllActiveUsers(): array
    {
        $rows = $this->getQuery()
            ->from(self::TABLE)
            ->where(['status' => UserStatusEnum::ACTIVE])
            ->all();
        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->mapToDto($row);
        }
        return $result;
    }
    private function mapToDto(array $user): UserDto
    {
        return new UserDto(
            id: $user["id"],
            username: $user["username"],
            status: $user["status"],
            createdAt: $user["created_at"],
            passwordHash: $user["password_hash"],
            accessToken: $user["access_token"],
            authKey: $user["auth_key"],
        );
    }

}