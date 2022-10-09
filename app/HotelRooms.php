<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelRooms extends Model
{
    protected $table = "hotel_rooms";
    protected $fillable = ['id','hotel_restaurant_id','room_title','no_of_room','price','price_of_two_person','price_of_three_person','no_of_guest_single_room','room_details','child_allowed','no_of_child_allow','has_breakfast','breakfast_price','has_dinner','dinner_price','status','created_by','deleted_at','created_at','updated_at'];

     use SoftDeletes;

    public function  hotels_room_gallery(){
        return $this->hasMany('App\Gallery','hotel_room_id');
    }

    public function  room_features(){
        return $this->hasMany('App\HotelRoomFeature','hotel_room_id');
    }


    public function  room_offers(){
        return $this->hasMany('App\CommonOffers');
    }

}
