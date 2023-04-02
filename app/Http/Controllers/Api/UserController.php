<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UsersUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @return UserResource
     */
    public function show(): UserResource
    {
        $user = auth()->user();

        return UserResource::make($user);
    }

    /**
     * @param UsersUpdateRequest $request
     * @return UserResource
     */
    public function update(UsersUpdateRequest $request): UserResource
    {
        $user = auth()->user();
        $user->update($request->validated());

        return UserResource::make($user);
    }
}
