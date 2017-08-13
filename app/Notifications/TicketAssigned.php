<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TicketAssigned extends Notification
{
    use Queueable;

    public $ticket;

    public function __construct($ticket) {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ( method_exists($notifiable, 'routeNotificationForSlack' ) && $notifiable->routeNotificationForSlack() != null) ? ['slack'] : ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject("Ticket assigned: #" .$this->ticket->id . ": ". $this->ticket->title)
            ->view( "emails.ticket" ,[
                    "title"  => "Ticket assigned to " . $notifiable->name,
                    "ticket" => $this->ticket,
                    "url"    => route("tickets.show", $this->ticket),
            ]
        );
        if($this->ticket->requester->email){
            $mail->from($this->ticket->requester->email, $this->ticket->requester->name);
        }
        return $mail;
    }

    public function toSlack($notifiable) {
        return (new BaseTicketSlackMessage($this->ticket))
                ->content('Ticket assigned');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
