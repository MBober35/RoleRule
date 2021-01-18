<?php

namespace MBober35\RoleRule\Observers;

use App\Models\Rule;
use Illuminate\Support\Facades\Cache;
use MBober35\Helpers\Exceptions\PreventDeleteException;

class RuleObserver
{
    public function deleted(Rule $rule)
    {
        Cache::forget("rule:{$rule->policy}");
        $rule->roles()->sync([]);
    }
}
