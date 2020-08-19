<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;


class powersManagementController extends Controller
{
    public function index(Request $request)
    {
//$data=DB::select("select UserImage.id user_id,UserImage.name user_name,permissions.id permissions_id,permissions.name permissions_name,activation from UserImage,permissions,permission_user
//            where permission_user.permission_id=permissions.id and permission_user.user_id=UserImage.id")->;
//        $data = DB::table('permission_user')
//            ->where('user_id', '=', 'permission_user.UserImage.id')
//            ->where('permission_id', 'permission_user.id', '=', 'permissions.id')
//            ->select(
//                'permission_user.activation',
//                'UserImage.id as user_id',
//                'UserImage.name as user_name',
//                'permissions.id as permissions_id',
//                'permissions.name as permissions_name'
//            )
//            ->get();
        if($request->table_type=='role')
        {
            $role_permission = [];
            $roles=Role::when($request->search,function ($q) use ($request){
                return $q->where('name','like','%'.$request->search.'%');
            })->get();
            foreach ($roles as $role) {
                foreach ($role->permissions as $perm) {
                    $role_permission[] = $perm;
                }
            }
            return view('dashboard.powersManagement.index',compact('role_permission'));
        }
        else {
            $user_permissions = [];
            if (isset($request->user_id)) {
                $user = User::where('id', $request->user_id)->first();
                foreach ($user->permissions as $perm) {
                    $user_permissions[] = $perm;
                }
            } else {
                $users=User::when($request->search,function ($q) use ($request){
                    return $q->where('name','like','%'.$request->search.'%');
                })->get();
                foreach ($users as $user) {
                    foreach ($user->permissions as $perm) {
                        $user_permissions[] = $perm;
                    }
                }
            }
            return view('dashboard.powersManagement.index',compact('user_permissions'));
        }
    }
    public function create(Request $request)
    {
        if($request->table_type=='role')
        {
            $permission=Permission::all();
            return view('dashboard.powersManagement.create',compact('permission'));
        }
        else
        {
            $roles=Role::all();
            return view('dashboard.powersManagement.create',compact('roles'));
        }
    }
    public function store(Request $request)
    {
        if($request->type_added=='permission') {
            $request->validate([
                'name' => 'required|string|unique:permissions,name',
                'description' => 'required|string|unique:permissions,description',
            ]);
            $request_data = $request->only('name', 'description');
            $permission = Permission::create($request_data);
            if ($request->role_id) {
                foreach ($request->role_id as $role) {
                    $permission->roles()->attach($role, ['activation' => 1]);
                }
            }
            foreach (User::all() as $user)
            {
                $user->permissions()->attach($permission->id,['activation'=>'0']);
            }
            session()->flash('success', 'the permission has been added');
        }
        else
        {
            $request->validate([
                'name' => 'required|string|unique:roles,name',
            ]);
            $request_data = $request->only('name');
            $role = Role::create($request_data);
            if ($request->permission_id) {
                foreach ($request->permission_id as $perm) {
                    $role->permissions()->attach($perm, ['activation' => 1]);
                }
            }
            session()->flash('success', 'the role has been added');
        }
        return redirect(route('dashboard.powersManagement.index'));
    }
    public function show($role_id)
    {
        $role=Role::where('id',$role_id)->first();
        $users= $role->users;
        return view('dashboard.powersManagement.showRoleUser',compact('role','users'));
    }
    public function edit($id)
    {
        //
    }

    public function showFormUpdateRolePermission(Request $request, $id)
    {
        $role=Role::where('id',$id)->first();
        $permissions_not_available = Permission::whereDoesntHave('roles', function (Builder $query) use ($id) {
            $query->where('role_id', '=', $id);
        })->get();
        $permissions_available = Permission::whereHas('roles', function (Builder $query) use ($id) {
            $query->where('role_id', '=',$id);
        })->get();
        return view('dashboard.powersManagement.editRolePermission',compact('permissions_available','permissions_not_available','role'));
    }
     public function updateRolePermission(Request $request, $id)
    {
        $role=Role::where('id',$id)->first();
        $value=0;
        foreach (Permission::all() as $perm) {
            if ($perm->id == $request->permission_id) {
                if ($role->permissions->find($perm->id)) {
                    if ($role->permissions->find($perm->id)->pivot->activation == 0) {
                        $value = 1;
                    } else {
                        $value = 0;
                    }
                    $role->permissions()->updateExistingPivot($perm->id, ['activation' => $value]);
                } else {
                    $role->permissions()->attach($perm->id, ['activation' => 1]);
                }
            }
        }
        return redirect()->back();
    }
    public function updateRoleUser(Request $request, $id)
    {
        $user=User::where('id',$id)->first();
        $role=Role::where('id',$request->role_id)->first();
        $value=0;
        foreach ($user->roles as $rol)
        {
            if($rol->id==$role->id) {
                if ($rol->pivot->activation == 0) {
                    $value = 1;
                } else {
                    $value = 0;
                }
                break;
            }
        }
        //whereHas('users', function (Builder $query) use ($user) {
        //                $query->where('user_id', $user->id);
        //            })
//        $permissions=Permission::whereHas('roles', function (Builder $query) use ($request) {
//            $query->where('role_id', $request->role_id);
//        })->get();
        foreach ($role->permissions as $perm)
        {
            $user->permissions()->updateExistingPivot($perm->id,['activation'=>$value]);
        }
        $user->roles()->updateExistingPivot($role->id,['activation'=>$value]);
        return redirect()->back();

    }
    public function update(Request $request, $id)
    {
        $permission=Permission::where('id',$id)->first();
        $user=User::where('id',$request->user_id)->first();
        foreach ($user->permissions as $per)
        {
            if($per->id==$id) {
                if ($per->pivot->activation == 0) {
                    $value = 1;
                } else {
                    $value = 0;
                }
            }
        }
        $user->permissions()->updateExistingPivot($id , ['activation' => $value]);
        return redirect()->back();
    }
    public function destroy($id)
    {
        //
    }
}
