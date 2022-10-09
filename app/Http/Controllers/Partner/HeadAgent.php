<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\SocietyPlotsNumber;
use Illuminate\Support\Str;

class HeadAgent extends Controller
{
   
    public $bookingStatus;
    public function __construct(){
        $societyPlotsNumberObj = new SocietyPlotsNumber;
        $this->bookingStatus = $societyPlotsNumberObj->plotBookingStatuName;
      
    }

     public function page($page = NULL , $p1 = NULL){
        $data['title'] = "Lakhmanis | Head - $page";
        if(!Auth::check()){ return redirect('/'); }
        /*find Society which allocated to users*/
        $data['notifications'] = auth()->user()->unreadNotifications;
        if($page == "agents"){
            if(Auth::check()){
                if(Auth::user()->hasRole('head-agent')){
                    $data['agentList'] = User::where([['head_agent_id','=',Auth::user()->id]])->get();
                }else{
                    return redirect()->back();
                }
		    }
        }
        if($page == "agent"){
            if(empty($p1)){ return redirect()->back(); }
            $data['agentDetail'] = User::find($p1);
            $data['bookingStatus'] =  $this->bookingStatus;
            if($data['agentDetail'] != NULL){
                $query = SocietyPlotsNumber::where([['broker_id','=',$data['agentDetail']->id],['block.deleted_at','=',NULL]]);
                            $query->join('spciety_rooms as block',function($join){
                                $join->on('society_plots_numbers.society_plot_id','=','block.id');
                            });
                            $query->join('societies as society',function($join){
                                $join->on('society_plots_numbers.society_id','=','society.id');
                            });
                $data['plotsList'] = $query->select('society.name','block.title','society_plots_numbers.*')->get();
            }
        }
        /*load view for partner*/
        if(! view()->exists("admin.partner.$page")){
           return view('admin.404')->with($data);
        }
       return view("admin.partner.$page")->with($data);
    }

}
