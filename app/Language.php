<?php

namespace App;

class Language
{
    const EN   = 'en';
    const ES   = 'es';
    const CA   = 'ca';
    const FR   = 'fr';
    const DE   = 'de';
    const PTBR = 'pt-br';

    public static function available()
    {
        return [
            static::EN   => __('languages.en'),
            static::ES   => __('languages.es'),
            static::CA   => __('languages.ca'),
            static::FR   => __('languages.fr'),
            static::DE   => __('languages.de'),
            static::PTBR => __('languages.ptbr'),
        ];
    }

    //
}
