<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'instructor_id' => $this->instructor_id,
            'duration' => $this->duration,
            'level' => $this->level,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'cover' => $this->cover,
            'rating' => $this->rating,
            'category_id' => $this->category_id,
            'instructor' => new InstructorResource($this->whenLoaded('instructor')),
            'category' => $this->whenLoaded('category'),
            'lessons' => LessonResource::collection($this->whenLoaded('lessons')),

        ];
    }
}
