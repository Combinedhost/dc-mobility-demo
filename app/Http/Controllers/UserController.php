<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try {
            return UserResource::collection(User::all());
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Some error occurred while retrieving users'
            ], 500);
        }
    }
}
