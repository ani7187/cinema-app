<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:rooms,name,' . $this->route('room')->id,
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
            'published' => 'nullable|in:0,1',
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
            'name.required' => 'The room name is required.',
            'name.string' => 'The room name must be a string.',
            'name.max' => 'The room name cannot be longer than 255 characters.',
            'name.unique' => 'The room name must be unique.',
            'rows.required' => 'The number of rows is required.',
            'rows.integer' => 'The number of rows must be an integer.',
            'rows.min' => 'There must be at least 1 row.',
            'seats_per_row.required' => 'The number of seats per row is required.',
            'seats_per_row.integer' => 'The number of seats per row must be an integer.',
            'seats_per_row.min' => 'There must be at least 1 seat per row.',
        ];
    }
}
