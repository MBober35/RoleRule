# RoleRule

## Install

Установить [Helpers](https://packagist.org/packages/mbober35/helpers)

    php artisan migrate
    php artisan role-rule
    php artisan role-rule:make
    Добавить модели User трейт ShouldRole

Публикация конфигурации:

    php artisan vendor:publish --provider="MBober35\RoleRule\ServiceProvider" --tag=config

### Commands

Добавить пользователю роль админа:

    role-rule:admin
        {--email= : find user by email}
        {--id= : find user by id}

Создать стандартные роли, которые нельзя удалить:

    role-rule:default

Сгенерировать правила политик:

    role-rule:make

### Gates

`app-management` - Должно быть право "Управление приложением"
`role-management` - Должно быть право "Управление ролями"
`settings-management` - Только админ

### Middlewares

`management` - Gate `app-management`
`super` - Gate `settings-management`
`role-master` - Gate `role-master`