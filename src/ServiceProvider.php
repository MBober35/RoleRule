<?php

namespace MBober35\RoleRule;

use App\Models\Role;
use App\Models\Rule;
use App\Models\User;
use App\Observers\RoleObserver;
use App\Observers\RuleObserver;
use App\Observers\UserRoleObserver;
use App\Policies\ManagementPolicy;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider as BaseProvider;
use MBober35\RoleRule\Commands\InitRolesCommand;
use MBober35\RoleRule\Commands\InitRulesCommand;
use MBober35\RoleRule\Commands\RoleRuleCommand;
use MBober35\RoleRule\Commands\SetAdminRoleCommand;
use MBober35\RoleRule\Events\RoleRightsChange;
use MBober35\RoleRule\Events\UserRoleChange;
use MBober35\RoleRule\Listeners\RoleRuleCacheClear;
use MBober35\RoleRule\Listeners\UserRoleCacheClear;
use MBober35\RoleRule\Middleware\Managemet;
use MBober35\RoleRule\Middleware\SuperUser;

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
                InitRulesCommand::class,
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

        // Gates.
        $this->setGates();

        // Middleware.
        $this->setMiddleware();

        // Публикация конфигурации.
        $this->publishes([
            __DIR__ . '/config/role-rule.php' => config_path('role-rule.php'),
        ]);

        // События.
        $this->setEvents();
    }

    /**
     * Подписка на события.
     */
    protected function setEvents()
    {
        Event::listen(
            UserRoleChange::class,
            [UserRoleCacheClear::class, "handle"]
        );
        Event::listen(
            RoleRightsChange::class,
            [RoleRuleCacheClear::class, "handle"]
        );
    }

    /**
     * Middlewares.
     */
    protected function setMiddleware()
    {
        $this->app["router"]->aliasMiddleware("management", Managemet::class);
        $this->app["router"]->aliasMiddleware("super", SuperUser::class);
    }

    /**
     * Gates.
     */
    protected function setGates()
    {
        // У главной роли есть доступ ко всему.
        Gate::before(function (User $user, $ability) {
            if ($user->hasRole(Role::SUPER)) return true;
        });

        if (file_exists(app_path("Policies\ManagementPolicy.php"))) {
            Gate::define("app-management", [ManagementPolicy::class, "appManagement"]);
            Gate::define("settings-management", [ManagementPolicy::class, "settingsManagement"]);
        }
    }

    /**
     * Наблюдатели.
     */
    protected function addObservers()
    {
        if (
            file_exists(app_path("Observers\RoleObserver.php")) &&
            file_exists(app_path("Models\Role.php"))
        ) {
            Role::observe(RoleObserver::class);
        }

        if (
            file_exists(app_path("Observers\RuleObserver.php")) &&
            file_exists(app_path("Models\Rule.php"))
        ) {
            Rule::observe(RuleObserver::class);
        }

        if (
            file_exists(app_path("Observers\UserRoleObserver.php")) &&
            file_exists(app_path("Models\User.php"))
        ) {
            User::observe(UserRoleObserver::class);
        }
    }
}
