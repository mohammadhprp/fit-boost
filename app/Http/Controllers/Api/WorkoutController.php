<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserWorkout\UserWorkoutResource;
use App\Http\Resources\UserWorkout\UserWorkoutsResource;
use App\Models\UserWorkout;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WorkoutController extends Controller
{

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $workouts = UserWorkout::select('id', 'title')->get();

        return UserWorkoutsResource::collection($workouts);
    }

    /**
     * @param UserWorkout $workout
     * @return UserWorkoutResource
     */
    public function show(UserWorkout $workout): UserWorkoutResource
    {
        $workout->loadMissing('items.workout');
        return UserWorkoutResource::make($workout);
    }
}
