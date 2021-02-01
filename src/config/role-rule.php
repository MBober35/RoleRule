<?php

return [
    "rules" => [
        \App\Policies\ManagementPolicy::class => ["Управление", "management"],
        \App\Policies\UserPolicy::class => ["Пользователи", "users"],
    ],
];
