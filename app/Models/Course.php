<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $appends = [
        'rating'
    ];

    protected $fillable = [
        'instructor_id',
        'duration',
        'level',
        'title',
        'description',
        'price',
        'cover',
        'category_id',
        'status'
    ];

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
        return $this->belongsTo(Category::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
