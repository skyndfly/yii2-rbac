<?php

namespace app\commands;

use app\models\User;
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

        $contentManager = $auth->createRole('contentManager');
        $contentManager->description = 'Контент Менеджер';
        $auth->add($contentManager);

        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $auth->add($user);
        $auth->addChild($admin, $user);

        $bannedUser = $auth->createRole('bannedUser');
        $bannedUser->description = 'Забаненный';
        $auth->add($bannedUser);

        $this->stdout('Done!' . PHP_EOL);
    }

    public function actionTest()
    {

    }

}