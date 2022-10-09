<?php

namespace App\Listeners;

use Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Role;
use App\Notifications\PlotsStatus;
use App\User;

class SendNewPlotsBookingStatusNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $info;
    public $adminUsers;

    public function __construct()
    {
        /*Find admin users */
       $query = User::where([['roles.name','=','admin'],['users.email','!=',NULL]]);
                    $query->join('role_user',function($join){
                        $join->on('users.id','=','role_user.user_id');
                    });
                    $query->join('roles',function($join){
                        $join->on('role_user.role_id','=','roles.id');
                    });  

        $this->adminUsers = $query->select('users.*')->get(); 
       //$this->adminUsers  = User::find(8);
       
       /*  echo "<pre>";
        print_r($this->adminUsers);exit;
        exit; */
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $this->info = $event;
        Notification::send($this->adminUsers, new PlotsStatus($this->info)); 
    }
}
