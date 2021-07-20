<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Template;
use App\Models\User;
use http\Env\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class EmailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function registerEmail($userId)
    {
        $template = Template::where('title', 'Welcome')->first();
        $user = User::where('user_id', $userId)->first();

        $search = array('{first_name}', '{last_name}', '{user_id}', '{email}', '{phone}',
            '{address_line_1}', '{address_line_2}', '{city}', '{state}', '{country}', '{postcode}');
        $replace = array($user->first_name, $user->last_name, $user->user_id, $user->email, $user->phone,
            $user->address_line_1, $user->address_line_2, $user->city, $user->state, $user->country,
            $user->postcode);
        $html = str_replace($search, $replace, $template->code);

        Mail::send([], [], function ($message) use ($template, $html, $user) {
            $message->to([$user->email, env('ADMIN_MAIL', 'ganishkarcvp@gmail.com')])->subject($template->title);
            $message->setBody($html, 'text/html');
            $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
        });

        if (Mail::failures()) {
            return false;
        }
        return true;

    }

    public function sendEmail(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'user_id' => ['required', 'exists:users,user_id'],
                'title' => ['required', 'exists:templates,title']
            ]);
            if ($validator->fails()) {
                return $validator->errors();
            }

            DB::beginTransaction();
            $user = User::where('user_id', $request->input('user_id'))->first();

            $template = Template::where('title', $request->input('title'))->first();
            $search = array('{first_name}', '{last_name}', '{user_id}', '{email}', '{phone}',
                '{address_line_1}', '{address_line_2}', '{city}', '{state}', '{country}', '{postcode}');
            $replace = array($user->first_name, $user->last_name, $user->user_id, $user->email, $user->phone,
                $user->address_line_1, $user->address_line_2, $user->city, $user->state, $user->country,
                $user->postcode);
            $html = str_replace($search, $replace, $template->code);

            Mail::send([], [], function ($message) use ($template, $html, $user) {
                $message->to($user->email)->subject($template->title);
                $message->setBody($html, 'text/html');
                $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
            });
            if (Mail::failures()) {
                return response()->json([
                    'message' => 'Email not sent!'
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Email sent!'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => 'Server Error'
            ], 500);

        }
    }

}
