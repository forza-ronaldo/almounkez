<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['string', 'min:6', 'max:30', 'unique:users,name,' . $user->id],
            'current_password' => ['required', 'string', 'min:8'],
            'password' => ['string', 'min:8', 'confirmed','nullable'],
        ]);
        if (Hash::check($request->current_password,  Auth::user()->password)) {
            $request_data = $request->only(['name']);
            $request_data['password'] = Hash::make($request->password);
            $user->update($request_data);
            session()->flash('msg', 'تم التعديل بنجاح');
            return redirect(route('home'));
        }
        return view('user.edit', compact('user'))->with('msg_result_check_pass', 'كلمة السر الحالية غير صحيحة');
    }
}
