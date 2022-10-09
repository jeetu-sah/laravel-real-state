<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelRoomFeature extends Model
{
    protected $table = "hotel_room_features";
    protected $fillable = ['id','hotel_room_id','common_features_id','deleted_at','created_at','updated_at'];

    use SoftDeletes;

    public function hotel_room_features(){
        return $this->belongsTo('App\CommonFeatures' , 'common_features_id','id');
    }


    


   

      
}
