<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 3/16/2017
 * Time: 22:05
 */

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Log;

class PostController extends Controller
{

    //I-a toate posturile din DB in ordinde descresc. dupa data si le returneaza catre DashBoard View ca posts.
    public function getDashboard()
    {
        $posts = Post::orderBy('created_at' , 'desc')->get();

        return view('dashboard' , ['posts' => $posts]);
    }

    //Creeaza un post si face display la message
    public function postCreatePost(Request $request)
    {
        //Validation
        $this->validate($request, [
           'body' => 'required|max:1000'
        ]);

        $post = new Post();
        $post->body = $request['body'];

        //Checking daca postul e ok
        if($request->user()->posts()->save($post))
        {
            $message = 'Post successfully created';
        }
        return redirect()->route('dashboard')->with(['message' => $message]);
    }

    //Sterge un post si returneaza un mesaj
    public  function getDeletePost($post_id)
    {
        $post = Post::where('id' , $post_id)->first();
        if(Auth::user() != $post->user)
        {
            return redirect()->back();
        }


        $post->delete();
        return redirect()->route('dashboard')->with(['message' => 'Successfully deleted']);
    }

    //Editeaza un post si face notify la  Obseveri
    public function postEditPost(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
            ]);

        $post = Post::find($request['postId']);
        if(Auth::user() != $post->user)
        {
            return redirect()->back();
        }




        $postObs = Session::get('postData');

        Log::info('SIZE2 ' . (string)count($postObs));

        //NOTIFY OBS
        foreach ($postObs as $obs)
        {

            if($obs->id == $post->id)
            {
                $obs->notify($post);
                Log::info('HERE3 ' . $post->id);
                Log::info('HERE3 ' . count($post->observers));
            }

        }


        $post->body = $request['body'];
        $post->update();

        return response()->json(['new_body' => $post->body],200);
    }


    //Like/Dislike(true/false) la post si ii adauga pe cei care dau like la lista de observeri
    public function postLikePost(Request $request)
    {
        $post_id = $request['postId'];
        $is_like  = $request['isLike'] === 'true';//daca e true avem like daca nu e dislike
        $update = false;
        $post = Post::find($post_id);

        if(!$post)//daca nu gasesc
        {
            return null;
        }

        $user = Auth::user();

        //ATTACH LA OBSERVERI
        $post->attach($user);

        $postObs = new \SplObjectStorage;
        $postObs->attach($post);

        Log::info('ID ' . (string)$post->id);
        Log::info('SIZE ' . (string)count($postObs));

        Session::put('postData', $postObs);

        $like = $user->likes()->where('post_id', $post_id)->first(); //verificam daca user-ul a dat like deja la acest post
        if($like)
        {
            //verificam daca am dat like sau dislike , din DB
            $alrdy_like = $like->like;
            $update = true;//daca am ajuns aici inseamna ca exista deja in DB deci trb sa facem un update
            if($alrdy_like == $is_like)//daca ce avem in DB == cu cce am dat click atunci luam inapoi deci facem delete din DB
            {
                $like->delete();
                return null;
            }
        }
        else
        {

            //daca nu avem like in DB pt acest  cream unul
            $like = new Like();

        }

        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;

        if($update)//acest lucru ne spune daca aveam in DB like si acum am dat dislike at facem numai un update
        {
            $like->update();
        }
        else//aici nu avem defapt nimic in DB deci facem un save
        {
            $like->save();
        }

        return null;
    }
}