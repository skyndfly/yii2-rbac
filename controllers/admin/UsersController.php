<?php

namespace app\controllers\admin;


use app\services\contracts\PaginateUsersServiceContract;

class UsersController extends BaseController
{
    private PaginateUsersServiceContract $paginateUsersService;

    public function __construct(
        $id,
        $module,
        PaginateUsersServiceContract $paginateUsersService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->paginateUsersService = $paginateUsersService;
    }


    public function actionIndex()
    {
        $this->paginateUsersService->execute();
        return $this->render('index');
    }
}