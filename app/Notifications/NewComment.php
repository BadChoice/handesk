<?php

namespace App\Notifications;

use App\Requester;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewComment extends Notification implements ShouldQueue
{
    use Queueable;

    public $ticket;
    public $comment;

    public function __construct($ticket, $comment)
    {
        $this->ticket  = $ticket;
        $this->comment = $comment;
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
        if (isset($notifiable->settings) && $notifiable->settings->ticket_updated_notification == false) {
            return [];
        }
        if (method_exists($notifiable, 'shouldBeNotified') && !$notifiable->shouldBeNotified() ){
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
            ->subject(__('notification.ticketUpdated').": #{$this->ticket->id}: {$this->ticket->title}")
            ->replyTo(config('mail.fetch.username'))
            ->view('emails.ticket', [
                    'title'   => __('notification.ticketUpdated'),
                    'ticket'  => $this->ticket,
                    'comment' => $this->comment,
                    'url'     => $notifiable instanceof Requester ? route('requester.tickets.show', $this->ticket->public_token) : route('tickets.show', $this->ticket),
                ]
            );
        if ($this->shouldUseAgentName()) {
            $mail->from(config('mail.fetch.username'), $this->comment->author()->name);
        }

        return $mail;
    }

    private function shouldUseAgentName()
    {
        return $this->comment->author() instanceof User &&
               $this->comment->author()->email;
    }

    public function toSlack($notifiable)
    {
        return (new BaseTicketSlackMessage(null, $notifiable))
                ->content(__('notification.ticketUpdated'))
                ->attachment(function ($attachment) {
                    $attachment->title($this->ticket->requester->name.': '.$this->ticket->title, route('tickets.show', $this->ticket))
                               ->content(trans_choice('lead.status', 1).': '.__('ticket.'.$this->ticket->statusName())."\n\n".$this->comment->body);
                });
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
