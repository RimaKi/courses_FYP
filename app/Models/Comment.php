<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable=[
      'user_id',
      'lesson_id',
      'comment_id',
      'content'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function lesson(){
        return $this->belongsTo(Lesson::class);
    }

    public function replies(){
        return $this->hasMany(Comment::class)->with('replies'); //دعم الردود المتداخلة
    }
    public function parentComment(){
        return $this->belongsTo(Comment::class);
    }

}
