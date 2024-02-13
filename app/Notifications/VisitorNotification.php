<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VisitorNotification extends Notification
{
    use Queueable;
    protected $data;
    protected $subject;
    protected $email;
    protected $url;
    protected $btn_txt;

    /**
     * Create a new notification instance.
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
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from(config('mail.from.address'), config(('app.name')))
            ->subject($this->subject)
            ->line($this->data)
            ->action($this->btn_txt, url($this->url));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
