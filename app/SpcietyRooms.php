<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpcietyRooms extends Model
{
    protected $table = "spciety_rooms";
    /*in the society room table has stored society block list*/
    protected $fillable = ['id','society_id','title','room_area','plot_size_by_gaj','plot_value','number_of_plot','priority','deleted_at','created_at','updated_at'];

     use SoftDeletes;


    public function blocks(){
        return $this->belongsTo('App\Society','society_id');
    }

    public function blockPlotsNumber(){
        return $this->hasMany('App\SocietyPlotsNumber','society_plot_id')->orderBy('priority',"ASC");; 
    }

    public function societyDetail(){
        return $this->belongsTo('App\Society','society_id'); 
    }
}
