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
        try {
            $template = Template::where('title', 'welcome')->first();
            $user = User::where('user_id', $userId)->first();
            $search = array('{user-first-name}', '{user_id}', '{email}', '{phone}', '{address}');
            $replace = array($user->first_name, $user->user_id, $user->email, $user->phone,
                $user->address_line_1 . ',' . $user->address_line_2 . ',' . $user->city);
            $html = str_replace($search, $replace, $template->code);
            $data = [];
            Mail::send([], $data, function ($message) use ($template, $html, $user) {
                $message->to($user->email)->subject($template->title);
                $message->setBody($html, 'text/html');
                $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
            });
            if (Mail::failures()) {
                return false;
            }
            return true;
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Server Error'
            ], 500);
        }
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
            $search = array('{user-first-name}', '{user_id}', '{email}', '{phone}', '{address}');
            $replace = array($user->first_name, $user->user_id, $user->email, $user->phone,
                $user->address_line_1 . ',' . $user->address_line_2 . ',' . $user->city);
            $html = str_replace($search, $replace, $template->code);
            $data = [];
            Mail::send([], $data, function ($message) use ($template, $html, $user) {
                $message->to([$user->email, env('ADMIN_MAIL')])->subject($template->title);
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
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => 'Server Error'
            ], 500);

        }
    }

}
