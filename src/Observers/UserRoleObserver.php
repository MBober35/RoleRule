<?php

namespace MBober35\RoleRule\Observers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use MBober35\Helpers\Exceptions\PreventDeleteException;

class UserRoleObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        // Если пользователя создает другой пользователь.
        if (Auth::check()) {
            $user->email_verified_at = Carbon::now();
        }
    }

    /**
     * Перед удалением пользователя.
     *
     * @param User $user
     * @throws PreventDeleteException
     */
    public function deleting(User $user)
    {
        if ($user->hasRole(Role::SUPER)) {
            throw new PreventDeleteException("Невозможно удалить пользователя");
        }
        if (Auth::id() == $user->id) {
            throw new PreventDeleteException("Невозможно удалить себя");
        }
    }

    /**
     * После удаления.
     *
     * @param User $user
     */
    public function deleted(User $user)
    {
        $user->roles()->sync([]);
    }
}
