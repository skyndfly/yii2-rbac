<?php

namespace app\controllers\admin;



class ArticlesController extends BaseController
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['rules'] = [
            [
                'allow' => true,
                'roles' => ['canBlog'],
            ]
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        echo "<pre>";
        print_r(111);
        echo "</pre>";
        die;

    }
}