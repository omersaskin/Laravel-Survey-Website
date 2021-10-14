<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Survey;
use App\Models\SuccessSurvey;

class AuthController extends Controller
{
    
    /* Pages */

    public function home() {

        $control=Session::has('token');

        if(empty($control)) {
            $token_random=rand(1,5000);
            $token_visitor='visitor'.$token_random;
            Session::put('token', $token_visitor);
        }

        if(!Auth::check()) {
            $survey=Survey::paginate(3);
            return view('auth.login', compact('survey'));
        }
        
        $user = Auth::user();
        $user_id = Auth::id();
        $type=$user->type;

        if($type == 'admin') {
            $token="admin";

            $comments=Comment::all();

            $d7 = date("Y-m-d", strtotime("+ 3 day"));
            $d6 = date("Y-m-d", strtotime("+ 2 day"));
            $d5 = date("Y-m-d", strtotime("+ 1 day"));
            $d4 = date("Y-m-d");
            $d3 = date("Y-m-d", strtotime("- 1 day"));
            $d2 = date("Y-m-d", strtotime("- 2 day"));
            $d1 = date("Y-m-d", strtotime("- 3 day"));

            $m1=SuccessSurvey::whereDate('created_at', '=', $d1)->count();
            $m2=SuccessSurvey::whereDate('created_at', '=', $d2)->count();
            $m3=SuccessSurvey::whereDate('created_at', '=', $d3)->count();
            $m4=SuccessSurvey::whereDate('created_at', '=', $d4)->count();
            $m5=SuccessSurvey::whereDate('created_at', '=', $d5)->count();
            $m6=SuccessSurvey::whereDate('created_at', '=', $d6)->count();
            $m7=SuccessSurvey::whereDate('created_at', '=', $d7)->count();

            return view('datas', compact('token', 'comments', 'm1', 'm2', 'm3', 'm4', 'm5', 'm6', 'm7'));
        }

    }

    public function datas()
    {
        return view('datas');
    }

    public function surveys()
    {
        return view('surveys');
    }
    
    public function answer()
    {
        return view('answer');
    }

    /* Controller */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email=$request['email'];
        $password=$request['password'];

        $userLogin=Auth::attempt(['email' => $email, 'password' => $password, 'type' => 'user']);
        $adminLogin=Auth::attempt(['email' => $email, 'password' => $password, 'type' => 'admin']);

        if($userLogin) {
            return Redirect()->route('survey.index');
        } elseif($adminLogin) {
            return Redirect()->route('login');
        } else {
            return Redirect()->route('login');
        }

    }

    

    public function registration()
    {
        return view('auth.registration');
    }

    public function createRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return Redirect()->route('login')->withSuccess('Kayıt işleminiz gerçekleşti.');
    }

    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect()->route('login');
    }
}