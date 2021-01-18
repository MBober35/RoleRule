<?php

namespace MBober35\RoleRule\Commands;

use App\Models\Rule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

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
        $current = [];
        foreach (config("role-rule.rules") as $class => $title) {
            if (! $this->check($class)) {
                $this->removeIfExist($class);
                continue;
            }
            if (is_array($title)) {
                list($title, $slug) = $title;
            }
            else {
                $slug = "";
            }
            $rule = $this->createIfEmpty($class, $title, $slug);
            $current[] = $rule->policy;
        }
        $this->removeExcept($current);
    }

    /**
     * Удалить лишние.
     *
     * @param array $classes
     * @throws \Exception
     */
    protected function removeExcept(array $classes)
    {
        $rules = Rule::query()
            ->whereNotIn("policy", $classes)
            ->get();
        foreach ($rules as $rule) {
            $this->removeIfExist($rule->policy);
        }
    }

    /**
     * Удалить политику.
     *
     * @param string $class
     * @throws \Exception
     */
    protected function removeIfExist(string $class)
    {
        $rule = Rule::query()
            ->where("policy", $class)
            ->first();
        if (empty($rule)) return;
        $rule->delete();
        $this->info("Policy {$rule->title} deleted.");
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
