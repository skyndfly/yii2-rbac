<?php

namespace app\controllers\admin;


use app\dto\RegisterUserDto;
use app\services\user\contracts\PaginateUsersServiceContract;
use app\services\user\UserStoreService;
use app\widgets\form\UserCreateForm;
use DomainException;
use Exception;
use Yii;

class UsersController extends BaseController
{
    private PaginateUsersServiceContract $paginateUsersService;
    private UserStoreService $userStoreService;

    public function __construct(
        $id,
        $module,
        PaginateUsersServiceContract $paginateUsersService,
        UserStoreService $userStoreService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->paginateUsersService = $paginateUsersService;
        $this->userStoreService = $userStoreService;
    }


    public function actionIndex()
    {
        $users = $this->paginateUsersService->execute();
        return $this->render('index', [
            'users' => $users,
        ]);
    }

    public function actionCreate()
    {
        $formModel = new UserCreateForm();

        return $this->render('create', [
            'formModel' => $formModel,
        ]);
    }

    public function actionStore()
    {
        try {
            $this->getUserIdentity();
            $post = Yii::$app->request->post();
            $form = new UserCreateForm();
            if ($form->load($post) && $form->validate()) {
                $newUser = new RegisterUserDto(
                    username: $form->username,
                    password: $form->password
                );
                $this->userStoreService->execute($newUser, $this->getUserIdentity(), $form->role);
                Yii::$app->session->setFlash('success', "Пользователь '{$form->username}' добавлен.");
                return $this->redirect('/lk/users');
            }
            throw new DomainException('Произошла непредвиденная ошибка.');
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect('/lk/users/create');
        }
    }
}