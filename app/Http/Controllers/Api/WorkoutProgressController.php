<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkoutProgress\StoreWorkoutProgressRequest;
use App\Http\Requests\WorkoutProgress\UpdateWorkoutProgressRequest;
use App\Http\Resources\WorkoutProgress\WorkoutProgressesResource;
use App\Http\Resources\WorkoutProgress\WorkoutProgressResource;
use App\Models\UserWorkout;
use App\Models\WorkoutProgress;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkoutProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): WorkoutProgressesResource
    {
        $user_workout_ids = UserWorkout::select('id')->get()->pluck('id');

        $progresses = WorkoutProgress::select(
            'id', 'title', 'description',
            'started_at', 'ended_at'
        )->whereIn($user_workout_ids)->get();

        return WorkoutProgressesResource::make($progresses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkoutProgressRequest $request): WorkoutProgressResource
    {
        $workout_progress = WorkoutProgress::create($request->validated());

        return WorkoutProgressResource::make($workout_progress);
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkoutProgress $workoutProgress): WorkoutProgressResource
    {
        return WorkoutProgressResource::make($workoutProgress);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkoutProgressRequest $request, WorkoutProgress $workoutProgress): WorkoutProgressResource
    {
        $workoutProgress->update($request->validated());

        return WorkoutProgressResource::make($workoutProgress);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkoutProgress $workoutProgress): Response
    {
        $workoutProgress->delete();

        return response()->noContent();
    }
}
