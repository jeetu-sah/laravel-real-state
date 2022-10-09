<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Society extends Model
{
    protected $table = "societies";
    
    protected $fillable = ['id','name','slug_name','location','number_of_plots','priority','society_id','society_pdf_map_name','society_pdf_map_url','deleted_at','created_at','updated_at'];

 
    use SoftDeletes;

    protected static function boot() 
    {
      parent::boot();

      static::deleting(function($societies) {
         foreach ($societies->society_map()->get() as $society) {
            $society->delete();
         }
      });
    }

    public function society_map(){
        return $this->hasMany('App\Gallery','societiy_id');
    }


    public function users() {
        return $this->belongsToMany('App\User');
    }

    public function plotNumbers(){
        return $this->hasMany('App\SocietyPlotsNumber','society_id');
    }


    public function blocks(){
        return $this->hasMany('App\SpcietyRooms','society_id');
    }



}
