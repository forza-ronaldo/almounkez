<?php

namespace App;

use App\Notifications\sendEmailVerify;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public  function  sendVerificationEmail()
    {
        $this->notify(new sendEmailVerify($this));
    }
    public  function  verified()
    {
        return $this->token_verify===null;
    }
    protected $fillable = [
        'name', 'email', 'password','token_verify','token_reset_password'
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
