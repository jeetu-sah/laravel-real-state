<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model{

    protected $table = "galleries";
    protected $fillable = ['id','societiy_id','image_name','image_name_url','type','deleted_at','created_at','updated_at','status'];

    protected $galleryType = [1=>'Socity Map' , 2=>'Spciety Image']; 

    
    use SoftDeletes;


    public function society_map(){
        return $this->belongsTo('App\Society', 'societiy_id', 'id');
    }

    
}
