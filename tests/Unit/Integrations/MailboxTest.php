<?php

namespace Tests\Unit\Integrations;

use App\Services\Pop3\Mailbox;
use Tests\TestCase;

/** @group integrations */
class MailboxTest extends TestCase
{
    /** @test */
    public function can_fetch_from_pop3_account(){
        /*$mailBox = new Mailbox();
        $mailBox->login( config('mail.fetch.host'), config('mail.fetch.port'), config('mail.fetch.username'), config('mail.fetch.password') );
        $messages = $mailBox->getMessages();

        dd( $messages->first()->getAttachments() );
        dd ( $messages->first()->fromAddress, $messages->first()->fromName, $messages->first()->subject );*/
        //dd( $messages->first()->textPlain );
        //$mailBox->delete( $messages->first()->id ) ;
        //$mailbox->expunge();
    }

}
