<?php

namespace App;

use App\Notifications\sendEmailVerify;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*private const  PERMISSION=[
        'add_user'=>0,
        'read_user'=>1,
        'del_user'=>2,
        'upd_user'=>3,
        'sen_msg_user'=>4,
    ];
    public static function getPermission()
    {
        return self::PERMISSION;
    }
    public function checkRole($role)
    {
        if(array_key_exists($role, self::PERMISSION))
        {
            $result= pow(2 ,self::PERMISSION[$role]) & $this->power;
            if($result==0)
                return false;
            return true;
        }
        return  false;
    }*/
    public  function  sendVerificationEmail()
    {
        $this->notify(new sendEmailVerify($this));
    }
    public  function  verified()
    {
        return $this->token_verify===null;
    }
    protected $fillable = [
        'name', 'email', 'password','token_verify','token_reset_password','group_id'
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
