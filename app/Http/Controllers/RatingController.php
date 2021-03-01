<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserWiseRatingResource;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{

    /**
     * @param Request $request
     * @return UserWiseRatingResource|\Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        try {
            $ratings = User::with('rating_history.rated_by_user', 'average_rating');

            if ($request->filled('user_id')) {
                $ratings->where('id', $request->input('user_id'));
                return new UserWiseRatingResource($ratings->first());
            }

            return UserWiseRatingResource::collection($ratings->get());
        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Some error occurred while posting rating'
            ], 500);

        }


    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postRating(Request $request)
    {
        $this->validate($request, [
            'rating' => 'required|numeric|between:1,10',
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            if ($request->input('user_id') == auth()->id()) {
                return response()->json([
                    'message' => 'You cannot rate yourself'
                ], 403);
            }

            if (Rating::where('user_id', $request->input('user_id'))->where('rated_by_user_id', auth()->id())
                ->exists()) {
                return response()->json([
                    'message' => 'You have already rated this user'
                ], 403);
            }

            Rating::create([
                'user_id' => $request->input('user_id'),
                'rated_by_user_id' => auth()->id(),
                'rating' => $request->input('rating')
            ]);
            return response()->json([
                'message' => 'Rating added successfully'
            ]);

        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Some error occurred while posting rating'
            ], 500);
        }
    }
}
