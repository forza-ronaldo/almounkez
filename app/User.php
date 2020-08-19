<?php

namespace App;

use App\Notifications\sendEmailVerify;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public function checkPermission($permission)
    {
        $permission=Permission::where('name',$permission)->first();
        if(!$permission)
            return false;
        return $this->permissions->find($permission->id)->pivot->activation==1?true:false;
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'permission_user')->withPivot('activation');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class,'role_user')->withPivot('activation');
    }
    public  function  sendVerificationEmail()
    {
        $this->notify(new sendEmailVerify($this));
    }
    public  function  verified()
    {
        return $this->token_verify===null;
    }
    protected $fillable = [
        'name', 'email', 'password','token_verify','token_reset_password','group_id','image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
