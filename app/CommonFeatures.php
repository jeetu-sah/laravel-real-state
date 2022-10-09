<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommonFeatures extends Model{


    protected $table = "common_features";
    protected $fillable = ['id','user_id','main_service_id','icon_name','icon_url','icon_code','name','priority','deleted_at','created_at','updated_at'
    ];

      
    use SoftDeletes;

    public function main_service(){
        return $this->belongsTo('App\MainService' , 'main_service_id','id');
    }

    public function hotel_restaurant_features(){
        return $this->hasMany('App\HotelRestaurantFeature');
    }

    public function hotel_room_features(){
        return $this->hasMany('App\HotelRoomFeature');
    }

    public function hotel_feature(){
        return $this->hasOne('App\HotelRestaurantFeature');
    }


    public function scopeHotelFeatures($query){
        return $query->where('main_service_id','=',1);
    }

    
    
}
