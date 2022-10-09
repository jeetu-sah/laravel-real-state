<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    protected $table = "permissions";
    protected $fillable = ['id','name','display_name','description','created_at','updated_at'];
    public $guarded = [];
   
}
