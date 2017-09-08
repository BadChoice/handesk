<?php

namespace App\Authenticatable;

use App\User;

class Admin extends User
{
    use HasParentModel, AuthenticatableRoles;

    protected static $role = ['admin' => true];
}