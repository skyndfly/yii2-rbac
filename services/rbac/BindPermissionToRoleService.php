<?php

namespace app\services\rbac;

use Yii;

class BindPermissionToRoleService
{
    public function execute(string $roleName, array $permissions): void
    {
        $auth = Yii::$app->getAuthManager();
        $role = $auth->getRole($roleName);
        $currentPermissions = $auth->getPermissionsByRole($roleName);

        //Удаляем старые разрешения
        foreach ($currentPermissions as $permission) {
            $auth->removeChild($role, $permission);
        }

        // Добавляем новые разрешения
        foreach ($permissions as $permissionString) {
            $permission = $auth->getPermission($permissionString);
            if (!$auth->hasChild($role, $permission)) {
                $auth->addChild($role, $permission);
            }
        }
    }
}