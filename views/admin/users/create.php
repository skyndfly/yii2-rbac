<?php

use app\widgets\form\UserCreateForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var UserCreateForm $formModel */
$this->title = 'Создать';
$this->params['breadcrumbs'] = [
    ['label' => 'Пользователи', 'url' => '/lk/users'],
    $this->title
];
?>

<section>
    <h2>Создать нового пользователя</h2>


    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['lk/users/store'],
    ]); ?>
    <?= $form->field($formModel, 'username') ?>
    <?= $form->field($formModel, 'password') ?>
    <?= $form->field($formModel, 'password_repeat') ?>
    <?= $form->field($formModel, 'role')->dropDownList(UserCreateForm::availableRoles()) ?>
    <?= Html::submitButton('Создать пользователя', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</section>
