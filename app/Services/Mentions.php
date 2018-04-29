<?php

namespace App\Services;

use App\User;

class Mentions
{
    public static function arrayFor($user)
    {
        $users = auth()->user()->admin ? User::all() : $user->teamsMembers()->get();

        return $users->map(function ($user) {
            return [
                'username' => strtolower(str_replace(@' ', @'_', $user->name)),
                'name'     => $user->name,
                'image'    => gravatarUrl($user->email, 20),
            ];
        });
    }

    public static function usersIn($text)
    {
        return Mentions::findUsersFor(
            Mentions::findIn($text)
        );
    }

    public static function findIn($text)
    {
        $matches = null;
        preg_match_all('/@([a-zA-Z0-9_-Á-ÿ]+|\\[[a-zA-Z0-9_-Á-ÿ]+\\])/', $text, $matches);

        return $matches[1];
    }

    public static function findUsersFor($mentions)
    {
        $mentions = array_map(function ($mention) {
            return str_replace('_', ' ', $mention);
        }, $mentions);
        //return User::whereIn('name', $mentions)->get();
        $query = User::whereRaw('lower(name) in ?', str_replace(']', ')', str_replace('[', '(', json_encode($mentions))));
//        dd($query->toSql(), $query->getBindings());
//        return $query->get();
        return User::whereIn('name', $mentions)->get();
    }
}
