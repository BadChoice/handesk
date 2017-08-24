<?php

namespace App;

class Language {

    const EN = 1;
    const ES = 2;
    const CA = 3;
    const FR = 4;

    public static function available() {
        return [
            static::EN => __("languages.en"),
            static::ES => __("languages.es"),
            static::CA => __("languages.ca"),
            static::FR => __("languages.fr"),
        ];
    }

    //
}
