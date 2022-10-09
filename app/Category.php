<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Booking;

class Category extends Model{

    protected $table = "categories";
    protected $primaryKey = 'id';

    protected $fillable = ['id','parent_id','name','slug_name','description','service_charge','meta_tag','meta_desc','image','image_url','deleted_at','created_at','updated_at'];

    protected $guarded = [];

    use SoftDeletes;


    public function  bookings(){
        return $this->hasMany('Booking','category');
    }

}
