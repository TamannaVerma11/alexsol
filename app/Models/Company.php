<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'upload_company_img',
        'as_consultant',
        'size',
        'industry_type',
        'remainder_sent',
        'payment_cycle',
        'expire',
        'status',
        'show_tickets',
    ];
}
