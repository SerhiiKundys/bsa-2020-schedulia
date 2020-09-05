<?php

namespace App\Notifications;

use App\Entity\Event;
use App\Mail\BeforeEventMailForOwner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationBeforeEventForOwner extends Notification
{
    use Queueable;
    private $event;
    private $startMeetingUrl;

    public function __construct(Event $event, string $startMeetingUrl)
    {
        $this->event = $event;
        $this->startMeetingUrl = $startMeetingUrl;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new BeforeEventMailForOwner($this->event, $this->startMeetingUrl))->build();
    }
}
