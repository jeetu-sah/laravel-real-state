<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocietyUsers extends Model
{
    protected $table = "society_users";
    
    protected $fillable = ['id','society_id','user_id','created_at','updated_at'];



    public function society() {
        return $this->belongsTo('App\Society');
    }
}
