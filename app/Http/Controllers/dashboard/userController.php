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
    public  function __construct()
    {
        $this->middleware('permission:users_create')->only('create');
        $this->middleware('permission:users_read')->only('index');
        $this->middleware('permission:users_update')->only('edit');
        $this->middleware('permission:users_delete')->only('destroy');
        $this->middleware('permission:users_send_message')->only('showFormSendMessage');
    }
    public function index(Request $request)
    {

        $users = User::where('group_id',0)->when($request->search, function ($query) use ($request) {
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
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email', 'max:255',
            'power'=>'number,nullable',
            'password'=>'required|string|min:8|confirmed'
        ]);

        $request_data = $request->except(['password', 'password_confirmation']);
        $request_data['password'] = bcrypt($request->password);
        $request_data['group_id'] = 0;
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
           'power'=>'number,nullable',
        ]);
        $request_data=$request->all();
        $request_data['power'] = isset($power)?$power:null;
        $user->update($request_data);
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
