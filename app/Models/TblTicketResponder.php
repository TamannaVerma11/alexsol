<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\VisitorNotificationEvent;

class TblTicketResponder extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ticket_id',
        'user_id',
    ];

    /**
     * @param  string  $message
     * @return bool
     */
    public function sendMessage($to, $title, $message, $url, $btn_text)
    {
        $sent = event(new VisitorNotificationEvent($title, $message, $to, $url, $btn_text));
        return $sent;
    }
}
