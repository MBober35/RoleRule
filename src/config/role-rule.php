<?php

return [
    "adminLayout" => "layouts.admin",
    "rules" => [
        \App\Policies\ManagementPolicy::class => ["Управление", "management"],
        \App\Policies\UserPolicy::class => ["Пользователи", "users"],
    ],
];
