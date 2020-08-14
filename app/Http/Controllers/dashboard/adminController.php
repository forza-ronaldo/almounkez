<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Mail\sendMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class adminController extends Controller
{
    public  function __construct()
    {
        $this->middleware('permission:admins_create')->only('create');
        $this->middleware('permission:admins_read')->only('index');
        $this->middleware('permission:admins_update')->only('edit');
        $this->middleware('permission:admins_delete')->only('destroy');
    }
    public function index(Request $request)
    {
        $users = User::whereRoleIs('admin')->when($request->search, function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->search . '%');
        })->paginate(3);
        return view('dashboard.admin.index', compact('users'));
    }
    public function create()
    {
        return view('dashboard.admin.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email', 'max:255',
            'password'=>'required|string|min:8|confirmed',
            'permissions'=>'required|array'
        ]);
        $request_data = $request->except(['password', 'password_confirmation','permissions']);
        $request_data['password'] = bcrypt($request->password);
        $request_data['group_id']=1;
        $user = User::create($request_data);
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);//syncPermissions
        session()->flash('success', 'msg_add');
        return redirect(route('dashboard.admin.index'));
    }
    public function edit(User $user)
    {
        return  view('dashboard.admin.edit')->with('user', $user);
    }
    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'name'=>'required|string|max:255'.Rule::unique('users')->ignore($user->name,'name'),
            'email'=>'required|string|email', 'max:255'.Rule::unique('users')->ignore($user->email,'email'),
        ]);
        $request_data = $request->except('permissions');
        $user->update($request_data);
        if ($request->permissions) {
            $user->syncPermissions($request->permissions);
        }
        session()->flash('success', 'msg_edit');
        return redirect(route('dashboard.admin.index'));
    }
    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', 'msg_delete');
        return redirect(route('dashboard.admin.index'));
    }
}