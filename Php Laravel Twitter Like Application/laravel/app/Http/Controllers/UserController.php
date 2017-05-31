<?php
namespace App\Http\Controllers;

use App\User;
use App\Post;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Log;

class UserController extends Controller
{
    //SingUp pentru User si facem login
    public function postSignUp(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:120',
            'password' => 'required|min:4'
        ]);
        $email = $request['email'];
        $first_name = $request['first_name'];
        $password = bcrypt($request['password']);

        $user = new User();
        $user->email = $email;
        $user->first_name = $first_name;
        $user->password = $password;

        $user->save();

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    //Sign In User
    public function postSignIn(Request $request)
    {
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']]))
        {
            return redirect()->route('dashboard');
        }
        return redirect()->back();
    }

    //Logut User
    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    //Returneaza View-ul de account cu datele user-ului curest as user
    public function getAccount()
    {
        return view('account', ['user' => Auth::user()]);
    }

    //Face Save la ce editam in Account View
    public function postSaveAccount(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required | max:120'
        ]);

        $user = Auth::user();
        $user->first_name = $request['first_name'];
        $user->update();

        $file = $request->file('image');
        $filename = $request['first_name'] . '-' . $user->id . '.jpg';
        if($file)
        {
            Storage::disk('local')->put($filename, File::get($file));
        }

        return redirect()->route('account');
    }

    //Afiseaza Imaginea din Store
    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }

    //Face search la persoana pe care o cautam si ne afiseazao pagina similara cu Account
    public function postSearchAccount(Request $request)
    {

        $users = User::orderBy('created_at' , 'desc')->get();
        $posts = Post::orderBy('created_at' , 'desc')->get();
        foreach($users as $user)
        {

            if($user->first_name == $request['search_account'])
            {
                Log::info('NAME ' . $request['search_account']);
                $toUser = $user;


                return view('accountView', ['user' => $toUser , 'posts' => $posts]);
            }

        }


        \Session::flash('flash_message','User Not Found');
        return redirect()->route('dashboard');
    }

}
