<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => ['required'],
                'last_name' => ['required'],
                'email' => ['required', 'email', 'unique:users'],
                'phone' => ['required'],
                'address_line_1' => ['required'],
                'address_line_2' => ['required'],
                'city' => ['required'],
                'state' => ['required'],
                'country' => ['required', 'exists:countries,name'],
                'postcode' => ['required'],
            ]);
            if ($validator->fails()) {
                return $validator->errors();
            }

            DB::beginTransaction();
            $userData = $request->all();

            $code = Country::where('name', $request->input('country'))->first()->code;
            $id = User::exists() ? User::latest()->first()->id : 0;
            $userData['user_id'] = $code . rand(100, 1000) . ++$id;

            $user = User::create($userData);

            $email = new EmailController();
            $message = $email->registerEmail($user->user_id);
            if (!$message) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Error occured while sending email!'
            ]);
            }
            DB::commit();

            return response()->json($user);
        }  catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => 'Server Error'
            ], 500);

        }
    }
}
