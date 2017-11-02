<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class IdeaCreated extends Notification
{
    use Queueable;

    public $idea;

    public function __construct($idea)
    {
        $this->idea = $idea;
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
        if (isset($notifiable->settings) && $notifiable->settings->ticket_created_notification == false) {
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
            ->subject(__('notification.newTicket').": #{$this->idea->id}: {$this->idea->title}")
            ->replyTo(config('mail.fetch.username'))
            ->view('emails.ticket', [
                    'title'  => __('notification.newTicketCreated'),
                    'ticket' => $this->idea,
                    'url'    => route('tickets.show', $this->idea),
                ]
            );
        if ($this->idea->requester->email) {
            $mail->from($this->idea->requester->email, $this->idea->requester->name);
        }

        return $mail;
    }

    public function toSlack($notifiable)
    {
        return (new BaseTicketSlackMessage($this->idea, $notifiable))
                ->content(__('notification.ticketCreated'));
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
