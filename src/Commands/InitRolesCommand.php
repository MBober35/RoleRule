<?php

namespace MBober35\RoleRule\Commands;

use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class InitRolesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role-rule:default';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create default roles';

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
        if (! class_exists(Role::class)) return 0;

        foreach (Role::DEFAULT_ROLES as $key => $name) {
            $this->createIfEmpty($key, $name);
        }
    }

    /**
     * Создать роль если такой нет.
     *
     * @param $key
     * @param $title
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function createIfEmpty($key, $title)
    {
        try {
            $role = Role::query()
                ->where("key", $key)
                ->firstOrFail();
        } catch (\Exception $exception) {
            $role = Role::create(compact("key", "title"));
            $this->info("Created {$key} role");
        }
        return $role;
    }
}
