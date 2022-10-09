<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Gallery;

class CountriesCities extends Model
{
    protected $table = "countries_cities";
    
    protected $fillable = ['id','parent_id','state','name','slug_name','description','priority','deleted_at','created_at','updated_at'];
    

    use SoftDeletes;


    public function countries_cities(){
        return $this->hasMany('App\CountriesCities');
    }


    public function gallery(){
        return $this->hasMany('App\Gallery','countries_city_id');
    }

    
    public function scopeCountry($query){
        return $query->where('parent_id','=',0);
    } 

    public function scopeCity($query){
        return $query->where([['parent_id','!=',0] , ['state','!=',0]]);
    } 
}
