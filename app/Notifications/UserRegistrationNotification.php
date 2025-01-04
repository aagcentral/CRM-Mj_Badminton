<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegistrationNotification extends Notification
{
    use Queueable;
    protected $player;
    /**
     * Create a new notification instance.
     */
    public function __construct($player)
    {
        $this->player = $player;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'registration_no' => $this->player->registration_no,
            'name' => $this->player->name, // Ensure 'name' is retrieved from $this->player
            'email' => $this->player->email,
            'message' => "{$this->player->name} is a new player registered.", // Corrected 'name'
            'category' => 'registration',
            'locationID' => $this->player->locationID,
        ];
    }
}
