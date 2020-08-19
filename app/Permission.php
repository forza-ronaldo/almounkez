<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps=false;
    protected $fillable=['name','description'];
    public function users()
    {
        return $this->belongsToMany(User::class,'permission_user')->withPivot('activation');;
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class,'permission_role')->withPivot('activation');;
    }
}
