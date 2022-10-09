<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingGuestDetails extends Model
{
    protected $table = "booking_guest_details";
    protected $fillable = ['id','hotel_booking_id','number_of_adult','number_of_child','created_at','updated_at','offer_type'];


    public function booking_details(){
        return $this->belongsTo('App\HotelBooking' , 'hotel_booking_id','id');
    }

    
}
