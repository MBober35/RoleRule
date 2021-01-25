# RoleRule

## Install

Установить [Helpers](https://packagist.org/packages/mbober35/helpers)

    php artisan migrate
    php artisan role-rule
    php artisan role-rule:make
    Добавить модели User трейт ShouldRole

Публикация конфигурации:

    php artisan vendor:publish --provider="MBober35\RoleRule\ServiceProvider" --tag=config

## Commands

Добавить пользователю роль админа:

    role-rule:admin
        {--email= : find user by email}
        {--id= : find user by id}

Создать стандартные роли, которые нельзя удалить:

    role-rule:default

Сгенерировать правила политик:

    role-rule:make