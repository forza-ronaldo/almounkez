<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Mail\sendMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class userController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->search, function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->search . '%');
        })->paginate(3);
        return view('dashboard.users.index', compact('users'));
    } //end of index
    public function create()
    {
        return view('dashboard.users.create');
    }
    public function store(Request $request)
    {
            $request_data = $request->except(['password', 'password_confirmation']);
            $request_data['password'] = bcrypt($request->password);
            $user = User::create($request_data);
            session()->flash('success', 'msg_add');
            return redirect(route('dashboard.user.index'));
    }
    public function edit(User $user)
    {
        return  view('dashboard.users.edit')->with('user', $user);
    }
    public function update(Request $request, User $user)
    {
        $this->validate($request,[
           'name'=>'required|string|max:255'.Rule::unique('users')->ignore($user->name,'name'),
           'email'=>'required|string|email', 'max:255'.Rule::unique('users')->ignore($user->email,'email'),
        ]);
        $user->update($request->all());
        session()->flash('success', 'msg_edit');
        return redirect(route('dashboard.user.index'));
    }
    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', 'msg_delete');
        return redirect(route('dashboard.user.index'));
    }
    public function showFormSendMessage(User $user)
    {
        return view('dashboard.users.sendMessage',compact('user'));
    }
    public function sendMessage(Request $request,User $user)
    {
        $this->validate($request,[
           'message' =>'required|string|'
        ]);
        $details=['message'=>$request->message];
        Mail::to($user->email)->send(new sendMessage($details));
        session()->flash('success','The message has been sent successfully');
        return redirect(route('dashboard.user.index'));
    }
}
