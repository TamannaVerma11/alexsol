<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $data;
    public $subject;
    public $email;
    public $url;
    public $btn_txt;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($subject, $data, $email, $url, $btn_txt)
    {
        $this->data = $data;
        $this->subject = $subject;
        $this->email = $email;
        $this->url = $url;
        $this->btn_txt = $btn_txt;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
