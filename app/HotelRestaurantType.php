<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelRestaurantType extends Model
{
    protected $table = "hotel_restaurant_types";
    protected $fillable = ['id','stars','description','created_at','updated_at'];


    
}
