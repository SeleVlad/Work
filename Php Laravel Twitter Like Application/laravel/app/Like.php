<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Like extends Model
{
    public function user()//the user who likes or dislikes
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
