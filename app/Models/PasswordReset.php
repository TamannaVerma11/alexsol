<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    const TOKEN_LIFETIME_IN_MINUTE = 1;

    protected $primaryKey = 'email';

    public $incrementing = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['email', 'token', 'created_at'];

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeValid(Builder $query): Builder
    {
        return $query->where('created_at', '>=', Carbon::now()->subMinutes(self::TOKEN_LIFETIME_IN_MINUTE));
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeTokenValid(Builder $query): Builder
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays(self::TOKEN_LIFETIME_IN_MINUTE));
    }
}
