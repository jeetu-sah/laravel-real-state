<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelBooking extends Model
{
    protected $table = "hotel_bookings";
    protected $fillable = ['id','hotel_restaurant_id','hotel_room_id','first_name','last_name','email','mobile','check_in','check_out','total_room_price','has_breakfast','total_breakfast_price','has_dinner','dinner_price','total_price','booking_status','created_by','deleted_at','created_at','updated_at'];

    public $booking_status_title = ['A'=>'Active' , 'C'=>"Cancel" ,'P'=>'Pending'];

     use SoftDeletes;

     public function hotel_room(){
        return $this->belongsTo('App\HotelRooms' , 'hotel_room_id','id');
    }

    public function hotel_booking(){
        return $this->belongsTo('App\HotelRestaurant','hotel_restaurant_id','id');
    }

    public function booking_details(){
        return $this->hasMany('App\BookingGuestDetails','hotel_booking_id');
    }
}
