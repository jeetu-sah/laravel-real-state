<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelRestaurantFeature extends Model{
    
    protected $table = "hotel_restaurant_features";
    protected $fillable = ['id','hotel_restaurant_id','common_features_id','deleted_at','created_at','updated_at'];

    use SoftDeletes;

    public function hotel_restaurant_features(){
        return $this->belongsTo('App\CommonFeatures' , 'common_features_id','id');
    }


     /*public function hotel_feature(){
        $this->hasOne('App\CommonFeatures', 'common_features_id','id');
    }
*/
}
