<?php

namespace MBober35\RoleRule;

use App\Models\Role;
use App\Observers\RoleObserver;
use Illuminate\Support\ServiceProvider as BaseProvider;
use MBober35\RoleRule\Commands\InitRolesCommand;
use MBober35\RoleRule\Commands\RoleRuleCommand;
use MBober35\RoleRule\Commands\SetAdminRoleCommand;

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
                InitRolesCommand::class,
                SetAdminRoleCommand::class,
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

        // Подключение наблюдателей.
        $this->addObservers();
    }

    /**
     * Наблюдатели.
     */
    protected function addObservers()
    {
        if (class_exists(RoleObserver::class) && class_exists(Role::class)) {
            Role::observe(RoleObserver::class);
        }
    }
}
