<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelRastaurantToken extends Model{


    protected $table = "hotel_rastaurant_tokens";
    protected $fillable = ['id','user_id','token_number','has_hotel','has_restaurant', 'gst_number','gst_file_name', 'gst_file_url','pan_card_number','pan_file_name','pan_file_url','term_condition','profile_status','created_by','deleted_at','created_at','updated_at'];
    
    
     use SoftDeletes;

    public function user_hotel_restaurant_token(){
        $this->hasOne('App\User', 'user_id','id');
    }
 
}
