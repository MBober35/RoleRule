<?php

namespace MBober35\RoleRule\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ManagementPolicy
{
    use HandlesAuthorization;

    const APP_MANAGEMENT = 2;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public static function getPermissions()
    {
        return [
            self::APP_MANAGEMENT => "Управление приложением",
        ];
    }

    public function appManagement(User $user)
    {
        // TODO: make request
        return false;
    }

    public function settingsManagement(User $user)
    {
        return $user->isSuperUser();
    }
}
