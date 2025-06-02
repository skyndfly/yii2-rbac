<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class PostController extends Controller
{

    public function behaviors(){
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
    public function actionIndex()
    {
        return 111;
    }
}