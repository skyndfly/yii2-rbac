<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $auth->add($admin);

        $permission = $auth->createPermission('canAdmin');
        $permission->description = 'Право входа в админку';
        $auth->add($permission);

        $auth->addChild($admin, $permission);
        $auth->assign($admin, 1);

//        $contentManager = $auth->createRole('contentManager');
//        $contentManager->description = 'Контент Менеджер';
//        $auth->add($contentManager);
//
//        $user = $auth->createRole('user');
//        $user->description = 'Пользователь';
//        $auth->add($user);
//        $auth->addChild($admin, $user);
//
//        $bannedUser = $auth->createRole('bannedUser');
//        $bannedUser->description = 'Забаненный';
//        $auth->add($bannedUser);

        $this->stdout('Done!' . PHP_EOL);
    }

    public function actionCanAdmin()
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->createPermission('canAdmin');
        $permission->description = 'Право входа в админку';
        $auth->add($permission);

        $this->stdout('Done!' . PHP_EOL);
    }

    public function actionBindPermissionToRole()
    {
        $auth = Yii::$app->getAuthManager();

        $permission = $auth->getPermission('canAdmin');
        $admin = $auth->getRole('admin');

        $auth->addChild($admin, $permission);

        $this->stdout('Done!' . PHP_EOL);
    }

    public function actionCreateNewRole(string $roleName, string $description)
    {
        $auth = Yii::$app->getAuthManager();
        $role = $auth->createRole($roleName);
        $role->description = $description;
        $auth->add($role);
        $this->stdout('Done!' . PHP_EOL);
    }

    public function actionBindRole(string $roleName = 'admin', int $userId = 100)
    {
        $auth = Yii::$app->getAuthManager();
        $role = $auth->getRole($roleName);
        $auth->assign($role, $userId);
        $this->stdout('Done!' . PHP_EOL);
    }
}