# RoleRule

## Install

    php artisan migrate
    php artisan role-rule
    Добавить модели User трейт ShouldRole

## Commands

Добавить пользователю роль админа:

    role-rule:admin
        {--email= : find user by email}
        {--id= : find user by id}

Создать стандартные роли, которые нельзя удалить:

    role-rule:default