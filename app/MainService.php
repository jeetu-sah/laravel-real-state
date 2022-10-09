<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainService extends Model{


    protected $table = "main_services";
    
    protected $fillable = ['id','name','type','hide','status','deleted_at','created_at','updated_at'];
    

    use SoftDeletes;


    public function main_service(){
        return $this->hasMany('App\CommonFeatures');
    }

}
