<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketRatedNotification extends Notification
{
    use Queueable;

    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        if (isset($notifiable->settings) && $notifiable->settings->ticket_rated_notification == false) {
            return [];
        }

        return (method_exists($notifiable, 'routeNotificationForSlack') && $notifiable->routeNotificationForSlack() != null) ? ['slack'] : ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('notification.ticketRated').": #{$this->ticket->id}: {$this->ticket->title}")
            ->replyTo(config('mail.fetch.username'))
            ->view('emails.ticketRated', [
                    'title'  => __('notification.ticketRated'),
                    'ticket' => $this->ticket,
                    'url'    => route('tickets.show', $this->ticket),
                ]
            );
    }

    public function toSlack($notifiable)
    {
        return (new BaseTicketSlackMessage($this->ticket, $notifiable))
            ->content(__('notification.ticketRated').': '.$this->ticket->rating);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
