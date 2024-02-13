<?php

namespace App\Listeners;

use App\Events\UserNotificationEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;

class UserNotificationListener
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
     * @param  \App\Events\UserNotificationEvent  $event
     * @return void
     */
    public function handle(UserNotificationEvent $event)
    {
        $data = $event->data;
        $subject = $event->subject;
        $email = $event->email;
        $url = $event->url;
        $btn_txt = $event->btn_txt;

        $notification = new UserNotification($subject, $data, $email, $url, $btn_txt);

        Notification::route('mail', $email)
            ->notify($notification);
    }
}
