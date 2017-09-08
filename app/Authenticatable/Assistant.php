<?php

namespace App\Authenticatable;

use App\User;

class Assistant extends User
{
    use HasParentModel, AuthenticatableRoles;

    protected static $role = ['assistant' => true];
}