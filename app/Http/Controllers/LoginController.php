<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    public function home(){
    	return view('auth.login');
    }

    public function validateUsers(Request $request){
    	$this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/login/postlogin');
        } 
        else 
        {
            return redirect()->back()->with('message','email and password did not exist');
        }
    }

    public function postLogin()
    {
        if(Auth::user()->role_id == 1){
            return redirect('/dashboard');
        }
        if(Auth::user()->role_id == 2){
            return redirect('/brokerage');
        }
        if(Auth::user()->role_id == 3){
            return redirect('/trucking');
        }
        if(Auth::user()->role_id == 4){
            return redirect('/billing');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }

    public function thome(){
        return view('/login/login2');
    }

    public function tvalidateUsers(Request $request){
        $user = User::all(); 
        foreach($user as $users){
            if(($users->email == $request->email) && ($users->password == $request->password))
            {
            	return view('/dashboard');
            }
        }
    }
}
