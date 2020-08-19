<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps=false;
    protected $fillable=['name'];
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'permission_role')->withPivot('activation');
    }
    public function users()
    {
        return $this->belongsToMany(User::class,'role_user')->withPivot('activation');
    }
}
