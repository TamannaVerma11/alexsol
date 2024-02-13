<?php

namespace App\Listeners;

use App\Events\VisitorNotificationEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VisitorNotification;

class VisitorNotificationListener
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
     * @param  \App\Events\VisitorNotificationEvent  $event
     * @return void
     */
    public function handle(VisitorNotificationEvent $event)
    {
        $data = $event->data;
        $subject = $event->subject;
        $email = $event->email;
        $url = $event->url;
        $btn_txt = $event->btn_txt;

        $notification = new VisitorNotification($subject, $data, $email, $url, $btn_txt);

        Notification::route('mail', $email)
            ->notify($notification);
    }
}
