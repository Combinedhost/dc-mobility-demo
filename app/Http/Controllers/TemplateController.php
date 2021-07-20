<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function addTemplate(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'title' => ['required', 'unique:templates'],
                'code' => ['required']
            ]);
            if ($validator->fails()) {
                return $validator->errors();
            }

            DB::beginTransaction();
            Template::create($request->all());
            DB::commit();

            return response()->json(['message' => 'Template created successfully!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'Server Error'
            ], 500);

        }

    }

}
