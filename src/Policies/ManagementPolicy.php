<?php

namespace MBober35\RoleRule\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use MBober35\RoleRule\Traits\ShouldRule;

class ManagementPolicy
{
    use HandlesAuthorization, ShouldRule;

    const APP_MANAGEMENT = 2;
    const ROLE_MANAGEMENT = 4;

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
            self::ROLE_MANAGEMENT => "Управление ролями",
        ];
    }

    /**
     * Управление ролями.
     *
     * @param User $user
     * @return bool
     */
    public function roleManagement(User $user)
    {
        return $this->checkPermit($user, self::ROLE_MANAGEMENT);
    }

    /**
     * Управление приложением.
     *
     * @param User $user
     * @return bool
     */
    public function appManagement(User $user)
    {
        return $this->checkPermit($user, self::APP_MANAGEMENT);
    }

    /**
     * Управление настройками.
     *
     * @param User $user
     * @return mixed
     */
    public function settingsManagement(User $user)
    {
        return $user->isSuperUser();
    }
}
