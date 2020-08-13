<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class verifyController extends Controller
{
    public function showInterfaceAccountDisabled()
    {
        return view('accountDisabled');
    }
    public function verify($token)
    {
        User::where('token_verify',$token)->firstOrFail()->update(['token_verify' => null]);
        session()->flash('success', 'The Verified Is Completed Success');
        return redirect()->route('home');
    }
    public function reSendEmailVerified(User $user)
    {
        $user->token_verify=Str::random(25);
        $user->sendVerificationEmail();
        $user->save();
        session()->flash('reSendEmailVerifiedSuccess','تم اعادة ارسال بريد التاكيد بنجاع ');
        return redirect()->back();
    }
}
