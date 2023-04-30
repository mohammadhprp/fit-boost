<?php

namespace App\Http\Controllers\Api;

use App\Constants\Strings\AppErrors;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\User\StoreUserNotificationRequest;
use App\Http\Requests\Notification\User\UpdateUserNotificationRequest;
use App\Http\Resources\Notification\User\UserNotificationResource;
use App\Http\Resources\Notification\User\UserNotificationsResource;
use App\Models\Notification;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $notifications = auth()->user()->notifications()
            ->select('id', 'title')
            ->get();

        return UserNotificationsResource::collection($notifications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserNotificationRequest $request): UserNotificationResource
    {
        $notification = auth()->user()->notifications()
            ->create($request->validated());

        return UserNotificationResource::make($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification): UserNotificationResource
    {
        if ($notification->notificationable_type != 'App\\Models\\User' ||
            $notification->notificationable_id != auth()->id()) {
            abort(ResponseAlias::HTTP_FORBIDDEN, AppErrors::Forbidden);
        }

        // Update [read_at] if it's null
        if ($notification->read_at == null) {
            $notification->update([
                'read_at' => now()
            ]);
        }

        return UserNotificationResource::make($notification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateUserNotificationRequest $request,
        Notification                  $notification
    ): UserNotificationResource
    {
        if ($notification->notificationable_type != 'App\\Models\\User' ||
            $notification->notificationable_id != auth()->id()) {
            abort(ResponseAlias::HTTP_FORBIDDEN, AppErrors::Forbidden);
        }

        $notification->update($request->validated());

        return UserNotificationResource::make($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification): Response
    {
        if ($notification->notificationable_type != 'App\\Models\\User' ||
            $notification->notificationable_id != auth()->id()) {
            abort(ResponseAlias::HTTP_FORBIDDEN, AppErrors::Forbidden);
        }

        $notification->delete();

        return response()->noContent();
    }
}
