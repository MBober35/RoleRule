<?php

namespace MBober35\RoleRule;

use Illuminate\Support\ServiceProvider as BaseProvider;
use MBober35\RoleRule\Commands\RoleRuleCommand;

class ServiceProvider extends BaseProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Команды.
        if ($this->app->runningInConsole()) {
            $this->commands([
                RoleRuleCommand::class,
            ]);
        }

        // Конфигурация.
        $this->mergeConfigFrom(
            __DIR__ . '/config/role-rule.php', "role-rule"
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Миграции.
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Адреса.
        $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');

        // Подключение шаблонов.
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'mbober-admin');
    }
}
