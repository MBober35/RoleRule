<?php


namespace MBober35\RoleRule\Traits;


use App\Models\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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

    /**
     * Проверить доступ.
     *
     * @param User $user
     * @param int $permision
     * @return bool
     */
    protected function checkPermit(User $user, int $permision)
    {
        $rule = $this->getRule();
        if (empty($rule)) return false;
        $roleIds = $user->role_ids;
        $rules = $this->getPermitByRoles($roleIds, $rule);
        foreach ($rules as $rights) {
            if ($rights & $permision) {
                return true;
            }
        }
        return false;
    }

    /**
     * Получить права по ролям.
     *
     * @param array $roleIds
     * @param Rule $rule
     * @return array
     */
    protected function getPermitByRoles(array $roleIds, Rule $rule)
    {
        $rules = [];
        foreach ($roleIds as $roleId) {
            $rules[] = Cache::rememberForever("rules:{$roleId}_{$rule->id}", function () use ($roleId, $rule) {
                $rights = DB::table("role_rule")
                    ->select("rights")
                    ->where("role_id", $roleId)
                    ->where("rule_id", $rule->id)
                    ->first();
                if (! empty($rights)) {
                    return $rights->rights;
                }
                else {
                    return 0;
                }
            });
        }

        return $rules;
    }

    /**
     * Получить класс политики.
     *
     * @return mixed
     */
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