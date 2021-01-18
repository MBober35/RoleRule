<?php


namespace MBober35\RoleRule\Traits;


use App\Models\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

trait ShouldRule
{
    public static function getPermissions()
    {
        return [];
    }

    public static function defaultRules()
    {
        return 0;
    }

    protected function checkPermit(User $user, int $permision)
    {
        $rule = $this->getRule();
        if (empty($rule)) return false;
        // TODO: get permission by role.
        return false;
    }

    protected function getRule()
    {
        $class = get_class($this);
        return Cache::rememberForever("rule:{$class}", function () use ($class) {
            try {
                return Rule::query()
                    ->select("id")
                    ->where("policy", $class)
                    ->firstOrFail();
            } catch (\Exception $exception) {
                return null;
            }
        });
    }
}