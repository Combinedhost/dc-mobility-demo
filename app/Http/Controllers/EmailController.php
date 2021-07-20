<?php

namespace App\Http\Controllers;
use App\Models\Country;
use App\Models\Template;
use App\Models\User;
use http\Env\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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

    public function registerEmail($userId){
        try {
            $templateCode = Template::where('title','welcome')->code;

            $user = User::where('user_id', $userId)->first();

            $html = str_replace('{user-first-name}', $user->first_name, $templateCode);

            $to_name = 'test';
            $to_email = 'ganicvp7@gmail.com';

            $data = [];
            Mail::send([], $data, function ($message) use ($html) {
                $message->to(['ganicvp7@gmail.com', 'gani'])->subject('Test Mail from Gani');
                $message->setBody($html, 'text/html');
                $message->from(env('MAIL_USERNAME'), 'gani');
            });
            return response()->json([
                'message' => 'Register Email send successfully'
            ]);

        }catch (\Exception $exception){

            return response()->json([
                'Server Error'
            ],500);

        }catch (ModelNotFoundException $exception){

            return response()->json([
                'Data not found'
            ],404);
        }


    }

    public function sendEmail(Request $request){
        try {
            $template_code = Template::first()->code;
            info($template_code);
            $code = str_replace('{user-first-name}', 'ganishkar', $template_code);
            info($code);
            $to_name = 'test';
            $to_email = 'ganicvp7@gmail.com';

            $data = [];
            Mail::send([], $data, function ($message) use ($code) {
                $message->to('ganicvp7@gmail.com', 'gani')->subject('Test Mail from Gani');
                $message->setBody($code, 'text/html');
                $message->from(env('MAIL_USERNAME'), 'gani');
            });

            $validator= $this->validate($request, [
                'user_id' => ['required', 'exists:users,user_id'],
                'title' => ['required']
            ]);

            if ($validator->fails()) {
                return $validator->errors();
            }



        }catch (\Exception $exception){

            return response()->json([
                'Server Error'
            ],500);

        }catch (ModelNotFoundException $exception){

            return response()->json([
                'Data not found'
            ],404);
        }


    }

}
