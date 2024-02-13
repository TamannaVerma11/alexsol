<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblReportRequest extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'permisson_ticket_title',
        'ticket_id',
        'user_id',
        'company_id',
        'report_id',
        'consultancy_id',
        'status',
        'permission_by',
        'request_date_time',
        'approval_date_time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'request_date_time' => 'datetime',
        'approval_date_time' => 'datetime',
    ];
}
