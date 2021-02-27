<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rating', 'rated_by_user_id', 'user_id'
    ];

    protected $table="ratings";

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function rated_by_user(){
        return $this->belongsTo(User::class);
    }
}
