<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileNotFoundException;

class RatingController extends Controller
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
      if(Rating::where('user_id',$request->input('user_id'))->where('rated_by_user_id',$request->input('rated_by_user_id'))->count()){
          return 'the user has already given rating';
      }
      else{
          Rating::create(['user_id'=> $request->input('user_id'),'rated_by_user_id'=>$request->input('rated_by_user_id'),'rating'=>$request->input('rating')]);
          return 'rating given';
      }
    }

    public function getIndividualAverageRating($id){
       $averageCount=Rating::where('user_id',$id)->count();
       $averageSum=Rating::where('user_id',$id)->sum('rating');
       return $averageSum/$averageCount;
    }

    public function getAllUserRating(){
       Log::info(User::with('rating_history')->get());
        return User::with('rating_history.rated_by_user')->get();
    }
}
