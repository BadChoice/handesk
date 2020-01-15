<?php

namespace App;

class Language
{
    const EN   = 'en';
    const ES   = 'es';
    const CA   = 'ca';
    const FR   = 'fr';
    const DE   = 'de';
    const IT   = 'it';
    const PTBR = 'pt-br';
    const ZHCN = 'zh-cn';
    const TR   = 'tr';

    public static function available()
    {
        return [
            static::EN   => __('languages.en'),
            static::ES   => __('languages.es'),
            static::CA   => __('languages.ca'),
            static::FR   => __('languages.fr'),
            static::DE   => __('languages.de'),
            static::IT   => __('languages.it'),
            static::PTBR => __('languages.ptbr'),
            static::TR   => __('languages.tr'),
            static::ZHCN => __('languages.zhcn'),
        ];
    }

    //
}
