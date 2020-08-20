<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Mail\sendMessage;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use function GuzzleHttp\Promise\all;
use PDF;
use phpDocumentor\Reflection\Types\Object_;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class userController extends Controller
{

    public function index(Request $request)
    {
        $roles=Role::all(); //where('group_id',$request->table_type)
        $roles_id=collect($roles)->map(function ($a){
            return $a->id;
        })->toArray();
        if(in_array($request->role,$roles_id))
        {
            $users = User::whereHas('roles', function (Builder $query) use ($request) {
                $query->where('role_id',$request->role);
            })->when($request->search, function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })->paginate(3);
        }
        else
        {
            $users = User::when($request->search, function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })->paginate(3);
        }
        return view('dashboard.users.index', compact('users','roles'));
    } //end of index
    public function create()
    {
        $roles=Role::all();
        return view('dashboard.users.create',compact('roles'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email', 'max:255',
            'power'=>'number,nullable',
            'password'=>'required|string|min:8|confirmed',
            'image'=>'image',
        ]);
        $permissions_id_taken_from_role = collect(Role::where('id', $request->role)->first()->permissions)->map(function ($permissions) {
            return $permissions->id;
        })->toArray();
        $request_data = $request->except(['password', 'password_confirmation']);
        $request_data['password'] = bcrypt($request->password);
        if($request->hasFile('image'))
        {
            Image::make($request->image)->resize(500,null,function ($constraint){
                $constraint->aspectRatio();
            })->save(public_path('Uploads/UserImage/'.$request->image->hashName()));
            $request_data['image']=$request->image->hashName();
        }
        $user = User::create($request_data);
        $user->roles()->attach($request->role ,['activation' => 1]);
        foreach (Permission::all() as $perrmission) {
            if (in_array($perrmission->id, $permissions_id_taken_from_role))
                $user->permissions()->attach($perrmission->id,['activation' => 1]);
            else
                $user->permissions()->attach($perrmission->id, ['activation' => 0]);
        }
        session()->flash('success', 'msg_add');
        return redirect(route('dashboard.user.index'));
    }
    public function edit(User $user)
    {
        $roles=Role::all();
       // $permissions=Permission::all();
        $roles_id=collect($user->roles)->map(function ($a){
            return $a->id;
        })->toArray();
        $roles_not_available = Role::whereDoesntHave('users', function (Builder $query) use ($user) {
            $query->where('user_id', '=', $user->id);
        })->get();
        $roles_available = Role::whereHas('users', function (Builder $query) use ($user) {
            $query->where('user_id', '=', $user->id);
        })->get();
        $role_taken_arr=collect($user->roles)->map(function ($q){
            return ['id'=>$q->id,'name'=>$q->name,'activation'=>$q->pivot->activation];
        })->toArray();
        return view('dashboard.users.edit')->with(['roles_available'=>$roles_available,'roles_not_available'=>$roles_not_available,'user'=> $user,'roles'=>$roles,'roles_id'=>$roles_id,'role_taken_arr'=>$role_taken_arr]);
    }
    public function update(Request $request, User $user)
    {
        // change permission include in old roles to zero
        $old_role_id_arr=collect($user->roles)->map(function ($s){
            return $s->id;
        })->toArray();
        $old_permissions_id_taken_from_role=[];
        $old_finaly_permissions_id_taken_from_role=[];
        foreach (Role::whereIn('id',$old_role_id_arr)->get() as $role)
        {
            $old_permissions_id_taken_from_role[]=collect($role->permissions)->map(function ($permission){
                return $permission->id;
            })->toArray();
        }
        for ($i=0;$i<count($old_permissions_id_taken_from_role);$i++)
        {
            $old_finaly_permissions_id_taken_from_role=array_merge($old_finaly_permissions_id_taken_from_role,$old_permissions_id_taken_from_role[$i]);
        }
        foreach ($old_finaly_permissions_id_taken_from_role as $f)
        {
            $user->permissions()->updateExistingPivot($f , ['activation' => 0]);
        }
        //end  change permission include in old roles to zero
        $roles=Role::all();
        $this->validate($request,[
           'name'=>'required|string|max:255'.Rule::unique('users')->ignore($user->name,'name'),
           'email'=>'required|string|email', 'max:255'.Rule::unique('users')->ignore($user->email,'email'),
           'power'=>'number,nullable',
        ]);
        $permissions_id_taken_from_role=[];
        $finaly_permissions_id_taken_from_role=[];
        foreach (Role::whereIn('id', $request->role)->get() as $role)
        {
            $permissions_id_taken_from_role[]=collect($role->permissions)->map(function ($permission){
               return $permission->id;
            })->toArray();
        }
        for ($i=0;$i<count($permissions_id_taken_from_role);$i++)
        {
            $finaly_permissions_id_taken_from_role=array_merge($finaly_permissions_id_taken_from_role,$permissions_id_taken_from_role[$i]);
        }
        foreach ($finaly_permissions_id_taken_from_role as $f)
        {
            $user->permissions()->updateExistingPivot($f , ['activation' => 1]);
        }
        foreach ($roles as $role)
        {
            $user->roles()->detach($role->id);
        }
        foreach ($request->role as $role) {
            $user->roles()->attach($role,['activation' => 1]);
        }
        foreach ($user->permissions as $per)
        {
            if(in_array($per->id,$finaly_permissions_id_taken_from_role)) {
                $user->permissions()->updateExistingPivot($per->id , ['activation' => 1]);
            }
        }
        $request_data=$request->all();
        if($request->hasFile('image'))
        {
            if($user->image!='default.png')
            {
                Storage::disk('public_uploads')->delete('/UserImage/'.$user->image);
            }

            Image::make($request->image)->resize(300,null,function($constraint){
                $constraint->aspectRatio();
            })->save(public_path('Uploads/UserImage/'. $request->image->hashName()));
            $request_data['image']=$request->image->hashName();
        }
        $user->update($request_data);
        session()->flash('success', 'msg_edit');
        return redirect(route('dashboard.user.index'));
    }
    public function destroy(User $user)
    {
        $role=Role::where('name','super_admin')->first();
        $super_admin_count = User::whereHas('roles', function (Builder $query) use ($role){
            $query->where('role_id', '=', $role->id);
        })->count();
        if($super_admin_count!=1) {
            $user->delete();
            session()->flash('success', 'msg_delete');
            return redirect(route('dashboard.user.index'));
        }
        session()->flash('success','you can\'t delete the last user');
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
    public  function pdf()
    {
        $users =User::paginate(5);
        $pdf = PDF::loadView('a', compact('users'));
        return $pdf->stream('document.pdf');
    }
    public function export(Request $request)
    {
        ob_end_clean();
        ob_start();
        $roles=Role::all();
        $roles_id=collect($roles)->map(function ($a){
            return $a->id;
        })->toArray();
        if(in_array($request->role,$roles_id))
        {

            $users = User::whereHas('roles', function (Builder $query) use ($request) {
                $query->where('role_id',$request->role);
            })->when($request->search, function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })->get(['id','name','email','created_at','updated_at']);

        }
        else
        {
            $users = User::when($request->search, function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })->get(['id','name','email','created_at','updated_at']);
        }

//        session()->flash('users',$users);
        return Excel::download(new UsersExport($users), 'users.xlsx');
    }
}
