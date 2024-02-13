<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MethodContent extends Model
{
    use HasFactory;

    public $timestamps = false;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'method_id',
        'name',
        'details',
        'language_id',
    ];
}
