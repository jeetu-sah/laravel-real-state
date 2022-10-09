<?php
namespace App;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Traits\LaratrustUserTrait;


class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "users";
    
	protected $fillable = ['id','f_name','l_name','user_name','provider','provider_id','email','email_verified_at' , 'mobile_verified_at','mobile','roll_id','password','commission','user_status','device_id','device_token','referel_code','own_referal_code','dob', 'wallet_amount','term_and_condition_status','is_signed','remember_token','proof_type_id','id_proof_number','proof','proof_url','description','priority','deleted_at','created_at','updated_at','user_id','partner_id','login_id','head_agent_id','hidden_user','customer_type'
    ];
    
    use SoftDeletes;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at'=>'datetime',
    ];
    
    protected $userTypes = [1=>"Admin" , 3=>'Super Admin', 2=>'Partners' , 4=>'Agent'];

    public function proofType(){
        return $this->belongsTo('App\ProofType');
    }


    public function societies() {
        return $this->belongsToMany('App\Society');
    }


    public function plotsNumbers() {
        return $this->hasMany('App\SocietyPlotsNumber');
    }

    

    public function mainOwnerList(){
        $query = User::where([['hidden_user','=',0] , ['r.name','=','main-owner']]);
                $query->join('role_user as ru',function($join){
                    $join->on('users.id','=','ru.user_id');
                }); 
                $query->join('roles as r',function($join){
                    $join->on('ru.role_id','=','r.id');
                }); 
                $query->select('users.*'); 
        $mainOwners = $query->get();
        return $mainOwners;
    }


    public function brokerList(){
        $query = User::where([['hidden_user','=',0] , ['r.name','=','agent']]);
                $query->orwhere([['r.name','=','head-agent']]);
                $query->join('role_user as ru',function($join){
                    $join->on('users.id','=','ru.user_id');
                }); 
                $query->join('roles as r',function($join){
                    $join->on('ru.role_id','=','r.id');
                }); 
                $query->select('users.*'); 
        $brokers = $query->get();
        return $brokers;
    }

    public function buyer(){
        $query = User::where([['hidden_user','=',0] , ['r.name','=','buyer']]);
                $query->orwhere([['r.name','=','buyer']]);
                $query->join('role_user as ru',function($join){
                    $join->on('users.id','=','ru.user_id');
                }); 
                $query->join('roles as r',function($join){
                    $join->on('ru.role_id','=','r.id');
                }); 
                $query->select('users.*'); 
        $brokers = $query->get();
        return $brokers;
    }

    
	

}
