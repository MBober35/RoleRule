<?php

namespace MBober35\RoleRule\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use MBober35\RoleRule\Events\UserRoleChange;

class UserRoleCacheClear implements ShouldQueue
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
    public function handle(UserRoleChange $event)
    {
        $user = $event->user;
        $user->clearRolesCache();
    }
}
