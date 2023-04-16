<?php

namespace App\Http\Controllers\Api;

use App\Constants\Strings\AppErrors;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserProgress\StoreUserProgressRequest;
use App\Http\Requests\UserProgress\UpdateUserProgressRequest;
use App\Http\Resources\UserProgress\UserProgressesResource;
use App\Http\Resources\UserProgress\UserProgressResource;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $progress = UserProgress::select('id', 'weight')->latest()->get();

        return UserProgressesResource::collection($progress);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserProgressRequest $request): UserProgressResource
    {

        $progress = UserProgress::create(
            ['user_id' => auth()->id()] + $request->validated()
        );

        return UserProgressResource::make($progress);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserProgress $progress): UserProgressResource
    {
        if ($progress->user_id != auth()->id()) {
            abort(403, AppErrors::Forbidden);
        }

        return UserProgressResource::make($progress);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserProgressRequest $request, UserProgress $progress): UserProgressResource
    {
        if ($progress->user_id != auth()->id()) {
            abort(403, AppErrors::Forbidden);
        }

        $progress->update($request->validated());

        return UserProgressResource::make($progress);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserProgress $progress): Response
    {
        if ($progress->user_id != auth()->id()) {
            abort(403, AppErrors::Forbidden);
        }

        $progress->delete();

        return response()->noContent();
    }
}
