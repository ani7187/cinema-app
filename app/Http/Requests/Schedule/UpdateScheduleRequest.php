<?php

namespace App\Http\Requests\Schedule;

use App\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateScheduleRequest extends FormRequest
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
            'room_id' => 'required|exists:rooms,id',
            'movie_id' => 'required|exists:movies,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'published' => 'nullable|in:0,1',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'room_id.required' => 'The room is required.',
            'room_id.exists' => 'The selected room does not exist.',
            'movie_id.required' => 'The movie is required.',
            'movie_id.exists' => 'The selected movie does not exist.',
            'start_time.required' => 'The start time is required.',
            'start_time.date' => 'The start time must be a valid date.',
            'start_time.after' => 'The start time must be in the future.',
            'start_time.unique' => 'There is already a schedule for this room at the selected time.',
            'end_time.required' => 'The end time is required.',
            'end_time.date' => 'The end time must be a valid date.',
            'end_time.after' => 'The end time must be after the start time.',
            'end_time.unique' => 'There is already a schedule for this room at the selected time.',
        ];
    }

    /**
     * @param $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $scheduleId = $this->route('schedule')->id; // Get the ID of the schedule being updated
            $startTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $this->start_time)->format('Y-m-d H:i:s');
            $endTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $this->end_time)->format('Y-m-d H:i:s');

            $overlap = Schedule::where('room_id', $this->room_id)
                ->where('id', '!=', $scheduleId) // Ignore the current schedule being updated
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function ($query) use ($startTime, $endTime) {
                            $query->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                        });
                })
                ->exists();

            if ($overlap) {
                $validator->errors()->add('start_time', 'A schedule already exists for this room during this time.');
            }
        });
    }
}
