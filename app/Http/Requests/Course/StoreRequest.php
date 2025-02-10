<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'duration' => ['required', 'numeric'],
            'level' => ['required', Rule::in(['beginner', 'intermediate', 'advance'])],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'cover' => ['file'],
            'category_id'=>['required','exists:categories,id'],
            'lessons'=>['required','array'],
            'lessons.*.title'=>['required','string'],
            'lessons.*.description'=>['nullable','string'],
            'lessons.*.files'=>['required','array'],
            'lessons.*.files.*.path'=>['required','file'],
            'lessons.*.files.*.type'=>['required',Rule::in(['video', 'file'])],
        ];
    }
}
