<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function index(){
        return 'create';
    }

    public function create(Request $request){
        return $request->all();
    }

    public function edit($id){
        return $id;
    }

    public function destroy(){
        return 'create';
    }
}
