<?php

namespace app\controllers\admin;

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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['canAdmin'],
                    ]
                ]
            ]
        ];
    }
}