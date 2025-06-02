<?php

namespace app\controllers\admin;


class AdminPageController extends BaseController
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}