<?php

namespace app\controllers;

use app\dto\RegisterUserDto;
use app\services\user\contracts\UserRegisterServiceContract;
use app\widgets\form\RegisterForm;
use DomainException;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    private UserRegisterServiceContract $userStoreService;

    public function __construct(
        $id,
        $module,
        UserRegisterServiceContract $userStoreService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->userStoreService = $userStoreService;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        //TODO вынести авторизацию в отдельный сервис
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        //TODO разобраться зачем это. Сброс пароля чтобы в вьюхе нельзя было его вывести?
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        $formModel = new RegisterForm();
        return $this->render('register', [
            'formModel' => $formModel,
        ]);
    }

    public function actionSignup()
    {
        try {
            $form = new RegisterForm();
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $dto = new RegisterUserDto($form->username, $form->password);
                $this->userStoreService->execute($dto);
                return $this->goHome();
            }
            throw new DomainException('Произошла непредвиденная ошибка');
        } catch (DomainException|Exception $exception) {
            Yii::$app->session->setFlash('error', $exception->getMessage());
            return $this->redirect('/site/register');
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
