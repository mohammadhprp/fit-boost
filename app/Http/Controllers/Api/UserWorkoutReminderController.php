<?php

namespace App\Http\Controllers\Api;

use App\Constants\Strings\AppErrors;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reminder\UserWorkout\StoreUserWorkoutReminderRequest;
use App\Http\Requests\Reminder\UserWorkout\UpdateUserWorkoutReminderRequest;
use App\Http\Resources\Reminder\UserWorkout\UserWorkoutReminderResource;
use App\Http\Resources\Reminder\UserWorkout\UserWorkoutRemindersResource;
use App\Models\Reminder;
use App\Models\UserWorkout;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserWorkoutReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserWorkout $userWorkout): AnonymousResourceCollection
    {
        $reminders = $userWorkout->reminders()
            ->select('id', 'title')
            ->get();

        return UserWorkoutRemindersResource::collection($reminders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserWorkoutReminderRequest $request, UserWorkout $userWorkout): UserWorkoutReminderResource
    {
        $reminder = $userWorkout->reminders()->create($request->validated());

        return UserWorkoutReminderResource::make($reminder);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserWorkout $userWorkout, Reminder $reminder): UserWorkoutReminderResource
    {
        if ($userWorkout->user->id != auth()->id()) {
            abort(403, AppErrors::Forbidden);
        }

        return UserWorkoutReminderResource::make($reminder);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateUserWorkoutReminderRequest $request,
        UserWorkout                      $userWorkout,
        Reminder                         $reminder): UserWorkoutReminderResource
    {
        if ($userWorkout->user->id != auth()->id()) {
            abort(403, AppErrors::Forbidden);
        }

        $reminder->update($request->validated());

        return UserWorkoutReminderResource::make($reminder);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserWorkout $userWorkout, Reminder $reminder): Response
    {
        if ($userWorkout->user->id != auth()->id()) {
            abort(403, AppErrors::Forbidden);
        }

        $reminder->delete();

        return response()->noContent();
    }
}
