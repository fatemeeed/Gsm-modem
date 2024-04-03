<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginForm()
    {
       
        return view('auth.login');
    }
    public function postLogin(Request $request)
    {

        $request->validate([

            'national_code' => 'required|digits:10',
            'password' => 'required',

        ]);

        // $credentials = $request->only('national_code', 'password');

        if (Auth::attempt(['national_code' => $request->national_code , 'password' => $request->password,'activation'=>1])) {


            return  redirect('panel');



        }

        return redirect()->route('auth.login')->with('alert-section-error', 'نام کاربری یا رمز عبور شما اشتباه است!');
    }

    public function logOut()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }
}
