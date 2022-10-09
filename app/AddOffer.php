<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddOffer extends Model
{
    protected $table = "add_offers";
    protected $fillable = ['id','hotel_restaurant_id','hotel_room_id','offer_name','available_quantity','available_quantity_per_user','offer_type','launching_date','available_date','closed_date','expiry_date','status','created_by','deleted_at','created_at','updated_at'];

     use SoftDeletes;

     public function hotel_room(){
        return $this->belongsTo('App\HotelRooms' , 'hotel_room_id','id');
    }
}
