<?php

namespace app\repositories;

use app\dto\RegisterUserDto;
use app\dto\UserDto;
use Yii;

class UserRepository extends BaseRepository
{
    public const TABLE = "users";

    public function findById(int $id): ?UserDto
    {
        $row = $this->getQuery()
            ->where(['id' => $id])
            ->from(self::TABLE)
            ->one();
        return $row ? $this->mapToDto($row) : null;

    }

    final public function findByUserName(string $username): ?UserDto
    {
        $row = $this->getQuery()
            ->where(['username' => $username])
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
            ])
            ->execute();

        return $this->findById(Yii::$app->db->getLastInsertID());
    }

    private function mapToDto(array $user): UserDto
    {
        $dto = new UserDto();
        $dto->id = $user["id"];
        $dto->username = $user["username"];
        $dto->passwordHash = $user["password_hash"];
        $dto->status = $user["status"];
        $dto->authKey = $user["auth_key"];
        $dto->accessToken = $user["access_token"];
        $dto->createdAt = $user["created_at"];
        return $dto;
    }
}