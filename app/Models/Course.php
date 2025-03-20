<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Course extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title', 'description'];

    protected $appends = [
//        'rating'
    ];

    protected $fillable = [
        'instructor_id',
        'duration',
        'level',
        'title',
        'description',
        'price',
        'cover',
        'sub_category_id',
        'status',
        'course_language'
    ];

    public function getTranslatedLevel(): string
    {
        return __('enums.level.' . $this->level);
    }

    public function getTranslatedLanguage(): string
    {
        return __('enums.course_language.' . $this->course_language);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }


    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function getRatingAttribute()
    {
        return $this->rates()->avg('rate');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'sub_category_id', 'id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
