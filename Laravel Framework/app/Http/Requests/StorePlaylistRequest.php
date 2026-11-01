<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlaylistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow authenticated users to create a playlist
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:100',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'nullable|string|max:500',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_public' => 'nullable|boolean',
            'songs' => 'nullable|array',
            'songs.*' => 'exists:songs,id',
        ];
    }

    /**
     * Custom validation messages (Session 11 requirement).
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The playlist title is required.',
            'name.min' => 'The playlist title must be at least 3 characters.',
            'genre_id.required' => 'Please select a valid musical genre.',
            'genre_id.exists' => 'The selected genre is not recognized.',
            'cover_image.image' => 'The uploaded file must be an image.',
            'cover_image.mimes' => 'Accepted image formats are JPG, JPEG, PNG, and WEBP.',
            'cover_image.max' => 'The cover image size must not exceed 2MB.',
        ];
    }
}
