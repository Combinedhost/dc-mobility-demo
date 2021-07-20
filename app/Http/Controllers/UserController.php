<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
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
            $validator = $this->validate($request, [
                'first_name' => ['required'],
                'last_name' => ['required'],
                'email' => ['required', 'email', 'unique:users'],
                'phone' => ['required'],
                'address_line_1' => ['required'],
                'address_line_2' => ['required'],
                'city' => ['required'],
                'state' => ['required'],
                'country' => ['required','exists:countries,name'],
                'postcode' => ['required'],
            ]);

            if ($validator->fails()) {
                return $validator->errors();
            }

            $code = Country::where('country', $request->input('country'))->code;

            $id = User::exists() ? User::latest()->id : 0;

            $validator['user_id'] = $code . rand(min(100)) . ++$id;

            $user = User::create($validator);

            $email = new EmailController();

            $email->registerEmail($user->user_id);

            return response()->json($user);

        } catch (\Exception $exception) {
            return response()->json([
                'Server Error'
            ], 500);

        } catch (ModelNotFoundException $exception) {

            return response()->json([
                'Data not found'
            ], 404);

        }
    }
}
