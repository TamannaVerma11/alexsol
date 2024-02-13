<?php

namespace App\Listeners;

use App\Events\AdminNotificationEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminNotification;
use App\Models\User;

class AdminNotificationListener
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
     * @param  \App\Events\AdminNotificationEvent $event
     * @return void
     */
    public function handle(AdminNotificationEvent $event)
    {
        $data = $event->data;
        $subject = $event->subject;
        $url = $event->url;
        $btn_txt = $event->btn_txt;

        $notification = new AdminNotification($subject, $data, $url, $btn_txt);

        //$admins = User::where('is_admin', '1')->get();
        $admins = User::get();
        Notification::send($admins, $notification);
    }
}
