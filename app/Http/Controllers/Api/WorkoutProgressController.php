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
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class WorkoutProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $user_workout_ids = UserWorkout::select('id')->get()->pluck('id');

        $workoutes = WorkoutProgress::select(
            'id', 'user_workout_id', 'title', 'description',
            'started_at', 'ended_at', 'created_at'
        )->whereIn('user_workout_id', $user_workout_ids)->get();

        return WorkoutProgressesResource::collection($workoutes);
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
    public function show(WorkoutProgress $workout): WorkoutProgressResource
    {
        return WorkoutProgressResource::make($workout);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkoutProgressRequest $request, WorkoutProgress $workout): WorkoutProgressResource
    {
        $workout->update($request->validated());

        return WorkoutProgressResource::make($workout);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkoutProgress $workout): Response
    {
        $workout->delete();

        return response()->noContent();
    }
}
