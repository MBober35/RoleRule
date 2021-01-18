<?php

namespace MBober35\RoleRule\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use MBober35\RoleRule\Traits\ShouldRule;

class ManagementPolicy
{
    use HandlesAuthorization, ShouldRule;

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

    public static function defaultRules()
    {
        return self::APP_MANAGEMENT;
    }

    public function appManagement(User $user)
    {
        return $this->checkPermit($user, self::APP_MANAGEMENT);
    }

    public function settingsManagement(User $user)
    {
        return $user->isSuperUser();
    }
}
