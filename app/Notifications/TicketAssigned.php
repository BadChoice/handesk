<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TicketAssigned extends Notification
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
        if (isset($notifiable->settings) && $notifiable->settings->ticket_assigned_notification === false) {
            return [];
        }

        return (method_exists($notifiable, 'routeNotificationForSlack') && $notifiable->routeNotificationForSlack() !== null) ? ['slack'] : ['mail'];
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
            ->subject(__('notification.ticketAssigned').': #'.$this->ticket->id.': '.$this->ticket->title)
            ->replyTo(config('mail.fetch.username'))
            ->view('emails.ticket', [
                    'title'  => __('notification.ticketAssignedTo').' '.$notifiable->name,
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
                ->content(__('notification.ticketAssigned'));
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
