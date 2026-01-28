<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContentAdded extends Notification
{
    use Queueable;

    protected $contentTitel;
    protected $contentType;
    protected $teatcher_name;
    public function __construct($teatcher_name , $contentTitel, $contentType)
    {
     $this->teatcher_name = $teatcher_name;
     $this->contentTitel = $contentTitel;
     $this->contentType=$contentType;

    }
      public function via($notifiable){
        return ['database','mail'];
      }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    // public function via(object $notifiable): array
    // {
    //     return ['mail'];
    // }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('New ' . $this->contentType . ' added: ' . $this->contentTitel)
            ->line('Added by ' . $this->teatcher_name)
            ->action('View Notifications', url('/notifications'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable){
        return [
            'title' => 'New ' . $this->contentType . ' Added',
            'message' => $this->contentTitel . ' added by ' . $this->teatcher_name,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
