<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IdeaCreated extends Notification implements ShouldQueue
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
        if (isset($notifiable->settings) && $notifiable->settings->new_idea_notification == false) {
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
            ->subject(__('notification.newIdea').": #{$this->idea->id}: {$this->idea->title}")
            ->replyTo(config('mail.fetch.username'))
            ->view('emails.idea', [
                    'title' => __('notification.newIdeaCreated'),
                    'idea'  => $this->idea,
                    'url'   => route('ideas.show', $this->idea),
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
                ->content(__('notification.newIdeaCreated'));
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
