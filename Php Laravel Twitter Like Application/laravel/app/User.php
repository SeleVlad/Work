<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Log;
use App\Pattern\Observer;


class User extends Model implements Authenticatable,Observer
{
    use \Illuminate\Auth\Authenticatable;

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    //Update
    public function updateObs($post)
    {
        Log::info('NOTIFYING ALL OBSERVERS');
        return redirect()->route('dashboard')->with(['message' => 'NOTIFY POST --' .$post->body .'-- EDITED']);
    }


}


