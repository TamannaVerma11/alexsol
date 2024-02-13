<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionContent extends Model
{
    use HasFactory;

    public $timestamps = false;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_id',
        'name',
        'tips_yes',
        'tips_no',
        'option1',
        'option2',
        'option3',
        'option4',
        'option5',
        'option6',
        'language_id',
        'is_response',
    ];
}
