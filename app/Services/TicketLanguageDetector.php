<?php

namespace App\Services;

use LanguageDetection\Language;

//https://github.com/patrickschur/language-detection
class TicketLanguageDetector
{
    private $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function detect()
    {
        $ld        = new Language(array_keys(\App\Language::available()));
        $text      = $this->ticket->body.' '.$this->ticket->comments()->pluck('body');
        $languages = $ld->detect($text)->close();

        return array_keys($languages)[0];
    }
}
