<?php

use app\widgets\form\RegisterForm;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/** @var RegisterForm $formModel */
$this->title = 'Создать аккаунт';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'register-form',
                'method' => 'post',
                'action' => ['site/signup'],
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 text-danger'],
                ]
            ])
            ?>
            <?= $form->field($formModel, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($formModel, 'password')->passwordInput() ?>
            <?= $form->field($formModel, 'password_repeat')->passwordInput() ?>
            <div class="form-group">
                <div>
                    <?= Html::submitButton('Создать', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>