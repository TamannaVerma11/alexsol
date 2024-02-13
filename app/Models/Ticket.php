<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'company_id',
        'name',
        'response',
        'summary',
        'review',
        'rating',
        'methods',
        'status',
        'time',
        'close_time',
        'review_status',
        'rating_status',
        'is_report_gen',
        'report_gen_time'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'close_time' => 'datetime',
        'time' => 'datetime',
        'report_gen_time' => 'datetime',
    ];
}
