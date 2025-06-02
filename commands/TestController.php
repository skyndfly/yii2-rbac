<?php


namespace app\commands;

use app\dto\RegisterUserDto;
use app\repositories\UserRepository;
use yii\console\Controller;
use yii\console\ExitCode;

class TestController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(
        $id,
        $module,
        UserRepository $userRepository,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->userRepository = $userRepository;
    }


    public function actionCreateUser(string $username, string $password
    ) {
        $dto = new RegisterUserDto(
            username: $username,
            password: $password
        );

        $user = $this->userRepository->save($dto);

        return ExitCode::OK;
    }
}
