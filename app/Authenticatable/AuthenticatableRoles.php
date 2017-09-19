<?php

namespace App\Authenticatable;

trait AuthenticatableRoles
{
    /**
     * Add Authenticatable filter during Eloquent Boot Up.
     */
    protected static function bootAuthenticatableRoles()
    {
        static::addGlobalScope(__CLASS__, function ($builder) {
            return $builder->where(static::$role);
        });
    }
}
