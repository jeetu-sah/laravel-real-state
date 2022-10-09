<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommonOffers extends Model
{

    protected $table = "common_offers";
    protected $fillable = ['id','hotel_restaurant_id','hotel_room_id','offer_name','offer_quantity','available_quantity_per_user','launching_date','closed_date','available_date','expiry_date','offer_type','offer_amount','image','image_path','status','created_by','deleted_at','created_at','updated_at'];

     use SoftDeletes;

    public function hotel_room_offers(){
        return $this->belongsTo('App\HotelRooms' , 'hotel_room_id','id');
    }

    public function hotel_offers(){
        return $this->belongsTo('App\HotelRestaurant', 'hotel_restaurant_id','id');
    }
}
