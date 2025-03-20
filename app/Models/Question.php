<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'question',
        'options',
        'correct_answer',
        'mark',
        'type'
    ];
    protected $casts = [
        'options' => 'json'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
