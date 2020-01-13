<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RateTicket extends Notification
{
    use Queueable;
    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        if (method_exists($notifiable, 'shouldBeNotified') && !$notifiable->shouldBeNotified() ){
            return [];
        }
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('notification.rateTicket').": #{$this->ticket->id}: {$this->ticket->title}")
            ->replyTo(config('mail.fetch.username'))
            ->view('emails.rateTicket', [
                    'title'   => __('notification.rateTicket'),
                    'ticket'  => $this->ticket,
                    'url'     => route('requester.tickets.rate', $this->ticket->public_token),
                ]
            );
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
