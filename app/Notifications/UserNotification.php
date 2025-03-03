<?php

namespace App\Notifications;

use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
    use Queueable;
    protected $notificationType;
    protected $notificationFrom;
    /**
     * Create a new notification instance.
     */
    public function __construct( $notificationType, $notificationFrom)
    {
        $this -> notificationType = $notificationType;
        $this -> notificationFrom = $notificationFrom;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
             'data' =>"You have new {$this -> notificationType} from {$this -> notificationFrom}",
        ];
    }
    // pusher
    public function toBroadcast($notifiable)
    {

        return new BroadcastMessage([
            'data'=>"You have new {$this -> notificationType} from {$this -> notificationFrom}",
        ]);
    }
    public function broadcastOn(){
        return ['my-channel'];
    }
}
