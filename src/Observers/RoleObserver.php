<?php

namespace MBober35\RoleRule\Observers;

use App\Models\Role;
use MBober35\Helpers\Exceptions\PreventDeleteException;

class RoleObserver
{
    public function deleting(Role $role)
    {
        if (! empty(Role::DEFAULT_ROLES[$role->key])) {
            throw new PreventDeleteException("Невозможно удалить роль");
        }
    }
}
