<?php

namespace MBober35\RoleRule\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use MBober35\RoleRule\Events\UserRoleChange;
use Symfony\Component\Finder\SplFileInfo;

class SetAdminRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role-rule:admin
                            {--email= : find user by email}
                            {--id= : find user by id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set role admin to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = null;

        if ($email = $this->option("email", false)) {
            $user = $this->findByEmail($email);
        }

        if ($id = $this->option("id", false)) {
            $user = $this->findById($id);
        }

        if (empty($user)) {
            $this->warn("User no found");
        }
        else {
            $this->setRoleToUser($user);
        }
    }

    /**
     * Добавить роль к пользователю.
     *
     * @param User $user
     */
    protected function setRoleToUser(User $user)
    {
        $role = $this->getAdminRole();
        if (empty($role)) {
            $this->warn("Role not found, please check model settings");
            return;
        }
        $role->users()->syncWithoutDetaching([$user->id]);
        UserRoleChange::dispatch($user);
        $this->info("Now {$user->name} is admin");
    }

    /**
     * Найти роль админа.
     *
     * @return Role|null
     */
    protected function getAdminRole()
    {
        try {
            $role = Role::query()
                ->where("key", Role::SUPER)
                ->firstOrFail();
        } catch (\Exception $exception) {
            $this->call("role-rule:default");
            $role = Role::query()
                ->where("key", Role::SUPER)
                ->first();
        }
        return $role;
    }

    /**
     * Найти пользователя по id.
     *
     * @param $id
     * @return null|User
     */
    protected function findById($id)
    {
        try {
            return User::query()
                ->where("id", $id)
                ->firstOrFail();
        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * Найти пользователя по e-mail.
     *
     * @param $email
     * @return null|User
     */
    protected function findByEmail($email)
    {
        try {
            return User::query()
                ->where("email", $email)
                ->firstOrFail();
        } catch (\Exception $exception) {
            return null;
        }
    }
}
