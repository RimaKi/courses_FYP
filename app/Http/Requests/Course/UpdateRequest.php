<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'instructor_id'=>['nullable','exists:users,id'],
            'duration'=>['nullable','numeric'],
            'level' => ['nullable', Rule::in(['beginner', 'intermediate', 'advance'])],
            'title'=>['nullable','string'],
            'description'=>['nullable','string'],
            'price'=>['nullable','numeric'],
            'cover'=>['nullable','file'],
            'category_id'=>['nullable','exists:categories,id']
        ];
    }
}
