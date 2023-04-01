<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserMeal\UserMealResource;
use App\Http\Resources\UserMeal\UserMealsResource;
use App\Models\UserMeal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MealController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $meals = UserMeal::select('id', 'title')->get();

        return UserMealsResource::collection($meals);
    }

    /**
     * @param UserMeal $meal
     * @return UserMealResource
     */
    public function show(UserMeal $meal): UserMealResource
    {
        $meal->loadMissing('items.meal');
        return UserMealResource::make($meal);
    }
}
