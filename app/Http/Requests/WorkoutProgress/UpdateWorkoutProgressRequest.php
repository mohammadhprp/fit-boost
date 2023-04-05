<?php

namespace App\Http\Requests\WorkoutProgress;

use App\Models\UserWorkout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkoutProgressRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        return [
            'user_workout_id' => [
                'required',
                Rule::exists(UserWorkout::class)->where(function ($q) {
                    return $q->where([
                        'user_id' => auth()->id(),
                        'user_workout_id' => $this->user_workout_id
                    ]);
                }),
            ],
            'title' => 'nullable',
            'description' => 'nullable',
            'started_at' => 'required',
            'ended_at' => 'required',
        ];

    }
}
