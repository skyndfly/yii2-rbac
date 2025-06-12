<?php
/** @var \app\dto\PaginateUserDto[] $users */


?>

<section>
    <h1>Список пользователей</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#id</th>
            <th>Логин</th>
            <th>Статус</th>
            <th>Разрешения</th>
            <th>Функции</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->userDto->id ?></td>
                <td><?= $user->userDto->username ?></td>
                <td><?= $user->userDto->status ?></td>
                <td>
                    <?php foreach ($user->roles as $role): ?>
                        <?= $role->name ?> <br>
                    <?php endforeach; ?>
                </td>
                <td></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
