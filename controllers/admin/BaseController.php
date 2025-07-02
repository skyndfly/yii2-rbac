<?php

namespace app\controllers\admin;

use app\auth\UserIdentity;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

abstract class BaseController extends Controller
{
    public $layout = 'admin'; // Использует views/layouts/admin.php

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['canAdmin'],
                    ]
                ]
            ]
        ];
    }

    protected function getUserIdentity(): ?UserIdentity
    {
        return Yii::$app->user->identity;
    }
}