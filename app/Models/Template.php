<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends model{

    public $table = 'templates';

    protected $fillable = [
        'title', 'code'
    ];

}
