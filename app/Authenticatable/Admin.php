<?php

namespace App\Authenticatable;

use App\User;
use Notification;

class Admin extends User
{
    use HasParentModel, AuthenticatableRoles;

    protected static $role = ['admin' => true];

    public static function notifyAll($notification){
        Notification::send( Admin::all() , $notification);
    }
}