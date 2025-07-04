<?php

namespace app\widgets\form;

use app\dto\AuthItemDto;
use Yii;
use yii\base\Model;

class BindPermissionToRoleForm extends Model
{
    public string $role = '';
    public array $permissions = [];

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        if (!empty($this->role)) {
            $auth = Yii::$app->authManager;
            $permissions = $auth->getPermissionsByRole($this->role);
            $this->permissions = array_keys($permissions);
        }
    }

    public function rules(): array
    {
        return [
            [['role'], 'required'],
            ['role', 'string'],
            ['permissions', 'each', 'rule' => [
                'in',
                'range' => array_keys($this->availablePermissions())
            ]],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'role' => 'Роль',
            'permissions' => 'Разрешения'
        ];
    }

    public function availablePermissions(): array
    {
        /** @var AuthItemDto[] $permissions */
        $permissions = Yii::$app->authManager->getPermissions();
        return array_map(
            fn($permission) => "{$permission->name} - {$permission->description}",
            $permissions
        );
    }
}