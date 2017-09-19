<?php

namespace App\Authenticatable;

use App\User;
use Notification;

class Assistant extends User
{
    use HasParentModel, AuthenticatableRoles;

    protected static $role = ['assistant' => true];

    public static function notifyAll($notification)
    {
        Notification::send(self::all(), $notification);
    }
}
