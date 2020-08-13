<?php

namespace App\Http\Controllers;

use App\Notifications\resetPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class resetPasswordController extends Controller
{
    public  function showResetPasswordForm()
    {
        return view('password.resetPassword');
    }
    public  function searchYourAccount(Request $request)
    {
        $token_reset = Str::random(25);
        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            $user->update(['token_reset_password' => $token_reset]);
            $user->notify(new resetPassword($user));
            return redirect()->back()->with('sendEmailToResetPassword', 'the email send');
        }
        return redirect()->back()->with('sendEmailToResetPassword', 'the email is not found');
    }
    public  function  showsetNewPassword($token_reset_password)
    {
        $user = User::where('token_reset_password', $token_reset_password)->first();
        if ($user != null)
            return view('password.showsetNewPassword', compact('user'));
        return view('error.404');
    }
    public  function  setNewPassword(Request $request, $id)
    {
        $this->validate($request,[
           'password'=>'required|min:8|confirmed'
        ]);
        $user = User::find($id)->update(
            [
                'password' => Hash::make($request->password),
                'token_reset_password' => null
            ]
        );
        return redirect()->route('login');
    }
}
