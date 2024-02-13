<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Fortify\TwoFactorAuthenticatable;
use App\Events\UserNotificationEvent;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_img',
        'password',
        'approve_per',
        'phone',
        'company_id',
        'tfa_email',
        'tfa_phone',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return string
     */
    public function newToken(): string
    {
        return $this->createToken('jwt')->plainTextToken;
    }

    /**
     * Always encrypt the password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * @return HasOne
     */
    public function passwordResetCode(): HasOne
    {
        return $this->hasOne(PasswordReset::class, 'email', 'email');
    }

    /**
     * @param  string  $message
     * @return bool
     */
    public function sendMessage($title,  $message, $url, $btn_text)
    {
        $sent = event(new UserNotificationEvent($title, $message, $this->email, $url, $btn_text));
        return $sent;
    }

    /**
     * User IP address location
     * @return bool
     */
    public function updateTracker($user_action)
    {
        $clientIP = request()->ip();
        //$data = Location::get($clientIP);
        $address_info = @unserialize(file_get_contents('http://ip-api.com/php/' . $clientIP));
        if ($address_info && $address_info['status'] == 'success')
            $data = $address_info['city'] . "/" . $address_info['country'];
        else
            $data = "Unknown";

        $tracker = Tracker::updateOrCreate([
            'user_id'   => $this->id,
        ],[
            'user_role' => $this->user_type,
            'user_ip' => $clientIP,
            'user_location' => $data,
            'access_time' => Carbon::now(),
            'user_action' => $user_action
        ]);

        return ($tracker) ? $tracker : null;
    }

}
