<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'path',
        'origin_name',
        'extension',
        'type'
    ];

    public function lesson(){
        return $this->belongsTo(Lesson::class);
    }
}
