<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class HotelRestaurant extends Model{


    protected $table = "hotel_restaurants";
    protected $fillable = ['id','user_id','description','hotel_restaurant_token_id','name','slug_name','hotel_restaurant_type','address','landmark','zip_code','address_lat','address_lang','city_id','state_id','countrie_id','phone_number','email','website_link','facebook_page_link','instagram_link','yt_channel_link','status','sold_status','has_meal','has_senetized','hotel_policis','meta_key_word','meta_description','created_by','uniqkeyid','deleted_at','created_at','updated_at'];

     use SoftDeletes;

    public function  hotels_restaurant_features(){
        return $this->hasMany('App\HotelRestaurantFeature');
    }

    public function  hotels_restaurant_gallery(){
        return $this->hasMany('App\Gallery');
    }

   


	


}
