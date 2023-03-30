<?php

namespace App\Classes\Passport\Helpers;

use DB;

class Provider
{
    public static function setProvider($grantType, $userId, $providerId = null)
    {
        DB::table('social_providers')->updateOrInsert([
            'user_id' => $userId
        ],[
            'provider' => $grantType,
            'provider_id' => $providerId,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
