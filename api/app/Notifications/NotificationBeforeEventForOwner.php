<?php

namespace App\Notifications;

use App\Entity\Event;
use App\Mail\BeforeEventMailForOwner;
use App\Notifications\Chatito\BeforeEventChatitoMessage;
use App\Notifications\Chatito\EventCreatedChatitoMessage;
use App\Notifications\SlackMessages\BeforeEventSlackMessageToOwner;
use App\Notifications\SlackMessages\EventCreatedSlackMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationBeforeEventForOwner extends Notification
{
    use Queueable;
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;

        if ($this->event->eventType->owner->chatito_active) {
            $this->toChatito();
        }
    }

    public function via($notifiable)
    {
        return ['mail', 'slack'];
    }

    public function toMail($notifiable)
    {
        return (new BeforeEventMailForOwner($this->event))->build();
    }

    public function toSlack($notifiable)
    {
        return new BeforeEventSlackMessageToOwner($this->event);
    }

    public function toChatito()
    {
        return new BeforeEventChatitoMessage($this->event);
    }
}
