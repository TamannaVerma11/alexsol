<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public $timestamps = false;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */ 
    protected $fillable = [
        'category_id',
        'type',
        'follow_up',
        'tip_on_yes',
        'tip_on_no',
        'yes_follow_up',
        'no_follow_up',
        'weight_yes',
        'weight_no',
        'is_response',
    ];
}
