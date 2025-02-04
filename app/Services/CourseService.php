<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Support\Facades\Storage;

class CourseService
{
    public function store(array $data)
    {
        if (array_key_exists('cover', $data)) {
            $data['cover'] = Storage::disk('public')->put('/course-cover', $data['cover']);
        }
        Course::create($data);
    }

    public function update(Course $course ,array $data){
        $data = array_filter($data);
        if($data['cover']){
            $data['cover']=(new FileService())->updatePhoto($data['cover'],$course->cover,'course-cover');
        }
        $course->update($data);
        return $course;
    }
}
