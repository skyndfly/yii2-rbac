<?php
/** @var \app\dto\PaginateUserDto[] $users */


?>

<section>
    <h1>Список пользователей</h1>
    <a href="/lk/users/create" class="btn btn-outline-success mb-3 d-flex align-items-center gap-1" style="width: fit-content">
        Создать пользователя
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
        </svg>

    </a>
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
