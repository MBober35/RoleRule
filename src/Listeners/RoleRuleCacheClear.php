<?php

namespace MBober35\RoleRule\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use MBober35\RoleRule\Events\RoleRightsChange;

class RoleRuleCacheClear implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRoleChange  $event
     * @return void
     */
    public function handle(RoleRightsChange $event)
    {
        $role = $event->role;
        $rule = $event->rule;
        Cache::forget("rules:{$role->id}_{$rule->id}");
    }
}
