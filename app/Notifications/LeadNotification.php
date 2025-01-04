<?php

namespace App\Notifications;

use App\Models\Enquiry;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;

class LeadNotification extends Notification
{
    use Queueable;

    protected $enquiry;

    /**
     * Create a new notification instance.
     */
    public function __construct($enquiry)
    {
        $this->enquiry = $enquiry;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database']; // Store the notification in the database
    }

    /**
     * Store the notification in the database.
     */
    public function toArray($notifiable)
    {
        return [
            'enquiry_Id' => $this->enquiry->enquiry_Id,
            'name' => $this->enquiry->name,
            'locationID' => $this->enquiry->locationID,
        ];
    }
}
