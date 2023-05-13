<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index(){
        return Inertia::render('Accounts/Signup');
    }

    public function store(Request $request){
        
        $input = $request->validate([
            'username' => 'required|alpha_num|lowercase|max:30',
            'email' => 'required|email',
            'password' => 'required|string|max:255|min:8'
        ]);

        $duplicated_users = User::select(['email','username'])
        ->where('email',$input['email'])
        ->orWhere('username',$input['username'])
        ->get();

        if(count($duplicated_users)){
            foreach ($duplicated_users as $key => $duplicated_user) {
                if ($duplicated_user->email == $input['email']){
                    return back()->withErrors([
                        'invalid' => 'Email already in use'
                    ]);
                }
                if ($duplicated_user->username == $input['username']){
                    return back()->withErrors([
                        'invalid' => 'Username already in use'
                    ]);
                }
            }
        }

        $input['password'] = bcrypt($input['password']);
        $created_user = User::create($input);
        $verifyEmailToken = Str::random(64);

        UserVerify::create([
            'user_id' => $created_user->id,
            'token' => $verifyEmailToken
        ]);
        
        Mail::send('email.emailVerificationEmail', ['token' => $verifyEmailToken], function($message) use($request){
            $message->to($request->email);
            $message->subject('Email Verification');
        });
       

        return redirect()->route('login.index')
            ->with('success',"Success! Please confirm your email address by clicking the link we sent you!");
    }

    public function show(){
        return Inertia::render('Accounts/AccountGeneral');
    }

    public function destroy(Request $request){
        $hasher = app('hash');

        $input = $request->validate([
            'password'=>'required|string|max:255|min:8'
        ]);

        if(!($hasher->check($input['password'], Auth::user()->password))){
            return back()->withErrors([
                'password' => 'Incorrect password'
            ]);
        }
        $user = Auth::user();
        Auth::logout();
        if ($user->delete()){
            return redirect()->route('login.index')
            ->with('info','Your account has been deleted');
        }
        return back()->withErrors([
            'password' => 'Internal server error'
        ]);
    }

    public function updatePassword(Request $request){
        $hasher = app('hash');

        $input = $request->validate([
            'current_password' => 'required|string|max:255',
            'new_password' => 'required|string|min:8|max:255|same:confirm_new_password',
            'confirm_new_password' => 'required|string|max:255'
        ],[
            'new_password.same'=>'Passwords must match'
        ]);

        $user = Auth::user();

        if (!($hasher->check($input['current_password'], $user->password))){
            return back()->withErrors([
                'current_password' => 'Incorrect password'
            ]);
        }

        $user->update([
            'password' => $hasher->make($input['new_password'])
        ]);


        return redirect()->route('account.show');
    }

    public function questions(){
        $questions = Auth::user()->questions;
        return Inertia::render('Accounts/AccountQuestions', [
            "questions" => $questions
        ]);
    }

    public function showLogout(){
        return Inertia::render('Accounts/AccountLogout');
    }

    public function showDelete(){
        return Inertia::render('Accounts/AccountDelete');
    }

    public function verifyEmail($token){
        $verifyUser = UserVerify::where('token', $token)->first();
  
        $message = 'Sorry, your email cannot be identified.';
  
        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
              
            if(!$user->email_verified_at) {
                $verifyUser->user->email_verified_at = Carbon::now();
                $verifyUser->user->save();
                $message = "Your e-mail is now verified. You can login!";
            } else {
                $message = "Your e-mail has already been verified. You can now login.";
            }
        }
  
      return redirect()->route('login.index')->with('info', $message);            
    }

    public function showForgotPassword(){
        return Inertia::render('Accounts/ForgotPassword');
    }

    public function storeForgotPassword(Request $request){
        $input = $request->validate([
            'email' => 'required|email',
        ]);    
        
        $user = User::where('email', $input['email'])
        ->whereNotNull('email_verified_at')->first();

        if (!$user){
            return back();
        }

        $passwordResetToken = date_create()->format('Uv') . Str::random(64);
        $passwordResetExpires = new DateTime();
        $passwordResetExpires->add(new DateInterval('PT1H'));
        
        $user->update([
            'password_reset_token' => $passwordResetToken,
            'password_reset_expires' => $passwordResetExpires
        ]);


        Mail::send('email.passwordResetEmail', ['token' => $passwordResetToken], function($message) use($user){
            $message->to($user->email);
            $message->subject('Password Reset');
        });
        
        return back();
    }

    public function showResetPassword(Request $request){
        $input = $request->validate([
            'token' => 'required|string'
        ]);

        return Inertia::render('Accounts/PasswordReset', [
            'token' => $input['token']
        ]);
    }

    public function storeResetPassword(Request $request){

        $input = $request->validate([
            'token' => 'required|string',
            'password' => 'required|string|max:255|min:8'
        ]);

        $user = User::where('password_reset_token', $input['token'])->first();

        if (!$user){
            return back()->withErrors([
                'invalid' => 'Invalid link'
            ]);
        }

        if(new DateTime($user->password_reset_expires) < new DateTime()){
            return back()->withErrors([
                'invalid' => 'This link is expired'
            ]);
        }
        $hasher = app('hash');

        $newPasswordHash = $hasher->make($input['password']);

        $user->update([
            'password' => $newPasswordHash,
            'password_reset_expires' => null,
            'password_reset_token' => null
        ]);

        return redirect()->route('login.index')->with('success', 'Your password has been changed!');
        
    }


}
