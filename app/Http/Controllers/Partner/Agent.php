<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\SocietyUsers;

class Agent extends Controller
{



    public function page($page = NULL , $p1 = NULL){
        $data['title'] = "Lakhmanis | Head - $page";
        if(!Auth::check()){ return redirect('/'); }
        /*find Society which allocated to users*/
        $data['notifications'] = auth()->user()->unreadNotifications;
        if($page == "societies"){
            if(Auth::check()){
               $data['societies'] = SocietyUsers::where([['user_id','=',Auth::user()->id]])->get();
		    }
        }
        /*load view for partner*/
        if(! view()->exists("admin.partner.agent.$page")){
           return view('admin.404')->with($data);
        }
       return view("admin.partner.agent.$page")->with($data);
    }
}
