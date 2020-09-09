<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Notifications\EventCreatedNotification;
use App\Notifications\EventCreatedNotificationToOwnerMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEventCreatedNotificationToOwner implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(EventCreated $eventCreated)
    {
//        $eventCreated->event->eventType->owner->notify(new EventCreatedNotification($eventCreated->event));
        $eventCreated->event->eventType->owner->notify(new EventCreatedNotificationToOwnerMail($eventCreated->event));
    }
}
