<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProofType extends Model
{
   
    protected $table = "proof_types";
    
	protected $fillable = ['id','name','created_at','updated_at'];


    public function proofTypes(){
        return $this->hasMany('App\User');
    }
}
