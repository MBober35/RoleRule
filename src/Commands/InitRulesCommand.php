<?php

namespace MBober35\RoleRule\Commands;

use App\Models\Rule;
use Illuminate\Console\Command;

class InitRulesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role-rule:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill rules table';

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
        foreach (config("role-rule.rules") as $class => $title) {
            if (! $this->check($class)) {
                // TODO: remove if no check.
                continue;
            }
            if (is_array($title)) {
                list($title, $slug) = $title;
            }
            else {
                $slug = "";
            }
            $this->createIfEmpty($class, $title, $slug);
        }
    }

    /**
     * Создать если пусто.
     *
     * @param string $policy
     * @param string $title
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|Rule
     */
    protected function createIfEmpty(string $policy, string $title, string $slug = "")
    {
        try {
            $rule = Rule::query()
                ->where("policy", $policy)
                ->firstOrFail();
        } catch (\Exception $exception) {
            $rule = Rule::create(compact("policy", "title", "slug"));
            $this->info("Policy {$title} created.");
        }
        return $rule;
    }

    /**
     * Проверка класса.
     *
     * @param string $class
     * @return bool
     */
    protected function check(string $class)
    {
        if (! class_exists($class)) false;
        if (! method_exists($class, "getPermissions")) false;
        return true;
    }
}
