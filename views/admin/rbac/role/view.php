<?php

use app\dto\AuthAssignmentDto;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

/** @var string $role */
/** @var ArrayDataProvider $dataProvider */

$this->title = $role;
$this->params['breadcrumbs'] = [
    ['label' => 'Роли и разрешения', 'url' => '/lk/rbac'],
    $this->title
];
?>

<section>
    <h2>Просмотр <?= $role ?></h2>

    <a href="" class="btn btn-outline-success mb-3 mb-3">Редактировать</a>
    <a href="/lk/rbac/role/<?= $role ?>/bind-permission" class="btn btn-outline-success mb-3 mb-3">Привязать
        разрешение</a>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{summary}\n{pager}",
        'columns' => [
            [
                'attribute' => 'user',
                'label' => 'Пользователь',
                'value' => function (AuthAssignmentDto $user) {
                    return $user->user->username;
                }
            ],
            [
                'attribute' => 'createdAt',
                'label' => 'Дата создания',
                'value' => function (AuthAssignmentDto $user) {
                    return (new DateTime())->setTimestamp($user->createdAt)->format('d-m-Y ');
                }
            ]
        ]
    ]) ?>
</section>