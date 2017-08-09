<?php

namespace Tests\Unit;

use App\Services\Pop3\Pop3;
use Tests\TestCase;

class Pop3Test extends TestCase
{
    /** @test */
    public function can_fetch_from_pop3_account(){
        $pop3 = new Pop3();
        $pop3->login("pop3.codepassion.io","110","hello@codepassion.io","mypassion!25");
        $messages = $pop3->getMessages();

//        dd ( $messages->first()->from() );
//        dd ( $messages->first()->subject() );
//        dd( $messages->first()->body() );
        //$messages->first()->delete();
        //$pop3->expunge();
    }
}
