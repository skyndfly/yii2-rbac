<?php

namespace app\controllers\admin;


use app\services\user\contracts\PaginateUsersServiceContract;

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
        $users = $this->paginateUsersService->execute();
        return $this->render('index', [
            'users' => $users,
        ]);
    }
}