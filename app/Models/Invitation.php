<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\VisitorNotificationEvent;

class Invitation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'status',
        'company_id',
        'accept_date',
    ];

    /**
     * @param  string  $message
     * @return bool
     */
    public function sendMessage($title, $message, $url, $btn_text)
    {
        $sent = event(new VisitorNotificationEvent($title, $message, $this->email, $url, $btn_text));
        return $sent;
    }
}
