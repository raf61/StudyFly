<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;


class LoginController extends Controller
{
    public function index(){
        return Inertia::render('Auth/Login');
    }

    public function store(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:255'
        ]);

        $auth_user = User::where('email', $credentials['email'])->first();
        if (!$auth_user || !Hash::check($credentials['password'], $auth_user->password)){
            return back()->withErrors([
                'credentials' => 'The provided credentials do not match our records'
            ]);
        }

        if (!($auth_user->email_verified_at)){
            return back()->withErrors([
                'credentials' => 'You must confirm your e-mail address. Check your e-mail box.'
            ]);
        }

        Auth::login($auth_user);
        
        $redirect_route = $request->header('X-Redirect-Back') == 'true' ? $request->header("Referer") : route('question.index');
            
        return redirect()->intended($redirect_route)->with('success','You have signed in!');
    }

    public function destroy(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.index')
        ->with('info','You have signed out');
    }

}
