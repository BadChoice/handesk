<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketEscalated extends Notification implements ShouldQueue
{
    use Queueable;

    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        if (isset($notifiable->settings) && $notifiable->settings->escalated_ticket_notification == false) {
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
        $mail = (new MailMessage)
            ->subject(__('notification.ticketEscalated').": #{$this->ticket->id}: {$this->ticket->title}")
            ->replyTo(config('mail.fetch.username'))
            ->view('emails.ticket', [
                    'title'  => __('notification.ticketEscalated'),
                    'ticket' => $this->ticket,
                    'url'    => route('tickets.show', $this->ticket),
                ]
            );
        if ($this->ticket->requester->email) {
            $mail->from($this->ticket->requester->email, $this->ticket->requester->name);
        }

        return $mail;
    }

    public function toSlack($notifiable)
    {
        return (new BaseTicketSlackMessage($this->ticket, $notifiable))
                ->content(__('notification.ticketEscalated'));
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
