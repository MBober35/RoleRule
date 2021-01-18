<?php

namespace MBober35\RoleRule\Events;

use App\Models\Role;
use App\Models\Rule;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoleRightsChange
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Role
     */
    public $role;
    /**
     * @var Rule
     */
    public $rule;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Role $role, Rule $rule)
    {
        $this->role = $role;
        $this->rule = $rule;
    }
}
