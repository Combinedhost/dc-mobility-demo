<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'password' => 'required|confirmed'
        ]);

        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

            $token = $user->createToken('Personal token')->accessToken;
            return response()->json([
                'token' => $token,
                'token_type' => 'Bearer'
            ], 200);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Some error occurred while registering'
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            $user = User::where('email', $request->input('email'))->first();
            if ($user && Hash::check($request->input('password'), $user->password)) {
                $token = $user->createToken('Personal token')->accessToken;
                return response()->json([
                    'token' => $token,
                    'token_type' => 'Bearer'
                ], 200);
            }

            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Some error occurred while logging in '
            ], 500);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            $token = auth()->user()->token();
            $token->revoke();

            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Some error occurred while logging out'
            ], 500);
        }
    }
}
