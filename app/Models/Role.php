<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    
    protected $table = "roles";
    protected $fillable = ['id','name','display_name','description','created_at','updated_at'];
    public $guarded = [];



    
}
