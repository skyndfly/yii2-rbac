<?php

namespace app\controllers;

use app\dto\AuthorizeUserDto;
use app\dto\RegisterUserDto;
use app\models\ContactForm;
use app\services\user\contracts\UserAuthorizeServiceContract;
use app\services\user\contracts\UserRegisterServiceContract;
use app\widgets\form\LoginForm;
use app\widgets\form\RegisterForm;
use DomainException;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SiteController extends Controller
{
    private UserRegisterServiceContract $userStoreService;
    private UserAuthorizeServiceContract $userAuthorizeService;

    public function __construct(
        $id,
        $module,
        UserRegisterServiceContract $userStoreService,
        UserAuthorizeServiceContract $userAuthorizeService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->userStoreService = $userStoreService;
        $this->userAuthorizeService = $userAuthorizeService;
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
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionAuthorize()
    {
        try {
            $form = new LoginForm();
            if ($form->load(Yii::$app->request->post())) {
                $dto = new AuthorizeUserDto($form->username, $form->password, $form->rememberMe);
                if ($this->userAuthorizeService->execute($dto)) {
                    return $this->goBack();
                }
            }
            throw new DomainException('Произошла непредвиденная ошибка');
        }catch (DomainException $e){
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect('/site/login');
        }
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
