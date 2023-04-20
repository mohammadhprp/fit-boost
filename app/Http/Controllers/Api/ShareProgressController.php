<?php

namespace App\Http\Controllers\Api;

use App\Constants\Strings\AppErrors;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShareProgress\StoreShareProgressRequest;
use App\Http\Requests\ShareProgress\UpdateShareProgressRequest;
use App\Http\Resources\ShareProgress\ShareProgressesResource;
use App\Http\Resources\ShareProgress\ShareProgressResource;
use App\Models\ShareProgress;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ShareProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $shares = ShareProgress::select('id', 'title')->latest()->get();

        return ShareProgressesResource::collection($shares);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShareProgressRequest $request): ShareProgressResource
    {
        $share = ShareProgress::create(
            ['user_id' => auth()->id()] + $request->validated()
        );

        return ShareProgressResource::make($share);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShareProgress $share): ShareProgressResource
    {
        if ($share->user_id != auth()->id()) {
            abort(403, AppErrors::Forbidden);
        }
        
        return ShareProgressResource::make($share);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShareProgressRequest $request, ShareProgress $share): ShareProgressResource
    {
        if ($share->user_id != auth()->id()) {
            abort(403, AppErrors::Forbidden);
        }

        $share->update($request->validated());

        return ShareProgressResource::make($share);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShareProgress $share): Response
    {
        if ($share->user_id != auth()->id()) {
            abort(403, AppErrors::Forbidden);
        }

        $share->delete();

        return response()->noContent();
    }
}
