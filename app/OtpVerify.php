<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OtpVerify extends Model{


    protected $table = "otp_verifies";
    protected $fillable = ['id','mobile_number','otp','otp_type' ,'otp_verified_at','deleted_at','created_at','updated_at'];
	
	use SoftDeletes;
    
}
