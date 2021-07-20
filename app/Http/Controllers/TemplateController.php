<?php

namespace App\Http\Controllers;
use App\Models\Country;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TemplateController extends Controller
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

    public function addTemplate(Request $request){
        try {
            $validator= $this->validate($request, [
                'title' => ['required'],
                'code' => ['required']
            ]);

            if ($validator->fails()) {
                return $validator->errors();
            }

            $template = Template::create([
                'title' => $request->input('title'),
                'code' => $request->input('code')
            ]);

            return response()->json($template);

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
