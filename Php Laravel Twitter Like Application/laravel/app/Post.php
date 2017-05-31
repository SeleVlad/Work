<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pattern\Subject;

class Post extends Model implements Subject
{
    private $observers;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }


    //SUBJECT PART FOR OBSERVER PATTERN
    public function attach($observer)
    {
        $this->observers->attach($observer);
    }

    public function detach($observer)
    {
        $this->observers->detach($observer);
    }

    public function notify($post)
    {
        foreach ($this->observers as $obs)
        {
            $obs->updateObs($post);
        }
    }

}
