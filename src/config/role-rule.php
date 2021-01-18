<?php

return [
    "adminLayout" => "layouts.admin",
    "rules" => [
        \App\Policies\ManagementPolicy::class => "Управление",
    ],
];
