<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'profile_picture' => $this->profile_picture,
            $this->mergeWhen($this->hasRole('instructor'),
                new InstructorResource(optional($this->instructor))
            ),
            'account' => $this->whenLoaded('account'),
            'courses' => $this->relationLoaded('courses') ? $this->courses :
                ($this->relationLoaded('coursesForInstructor') ? $this->coursesForInstructor : [])

        ];
    }
}
