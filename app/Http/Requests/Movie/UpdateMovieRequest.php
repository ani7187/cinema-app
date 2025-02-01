<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:movies,title,' . $this->route('movie')->id, // Title should be unique except for the current movie
            'poster_url' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Customize the error messages (optional).
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'The movie title is required.',
            'title.string' => 'The movie title must be a string.',
            'title.max' => 'The movie title cannot exceed 255 characters.',
            'title.unique' => 'A movie with this title already exists.',
            'poster_url.required' => 'The poster is required.',
            'poster_url.url' => 'The poster URL must be a valid URL.',
            'description.string' => 'The description must be a string.',
        ];
    }
}
