<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use sHelper;
use App\Models\Role;
use DB;


class UsersRoles extends Controller
{
    public function index(){
        $data['title'] = "lakhmanis | Users Allocation";
        /*Admin Un Read Notification*/
		$data['notifications'] = auth()->user()->unreadNotifications;  
        if(! view()->exists('admin.pages.users_allocation')){
           return view('admin.404')->with($data);
        }
        return view('admin.pages.users_allocation')->with($data);
    }
  


    public function page($page , $p1){
        $data['title'] = "lakhmanis | $page";
        if($page == "agent_allocation"){
            if(empty($p1))return redirect()->back();
            $data['user_detail'] = User::find($p1);
        }
        $data['notifications'] = auth()->user()->unreadNotifications; 
        if(! view()->exists("admin.pages.$page")){
           return view('admin.404')->with($data);
        }
        return view("admin.pages.$page")->with($data);
    }


    public function agentAllocateToHeadagent(Request $request){
        if(!empty($request->headAgentID)){
            if(!empty($request->userid)){
                /*allocate script strat*/
                $agent_user = User::find($request->userid);
                if($agent_user != NULL){
                    if($request->action ==  "allocate"){
                        $updateResponse = $agent_user->update(['head_agent_id'=>$request->headAgentID]);
                        if($updateResponse){
                            echo "Agent allocated successfully  !!!";exit;
                        }else{
                            echo "<div class='notice notice-danger notice'><strong>Wrong </strong> Agent not exists in our database !!! </div>";exit;
                        }
                    }
                    /*End*/
                    /*deallocate script strta*/
                    if($request->action ==  "dellocate"){
                        $deAllocateResponse = $agent_user->update(['head_agent_id'=>NULL]);
                        if($deAllocateResponse){
                           echo "Agent remove successfully  !!!";exit;
                        }else{
                            echo "Something went wrong , please try again ";exit;
                        }
                    }
                    /*End*/

                }else{
                    echo "<div class='notice notice-danger notice'><strong>Wrong </strong> Agent not exists in our database !!! </div>";exit;
                }
            }else{
                echo "<div class='notice notice-danger notice'><strong>Wrong </strong> Agent is required !!! </div>";exit;
            }

        }else{
            echo "<div class='notice notice-danger notice'><strong>Wrong </strong> Head Agent is required !!! </div>";exit;
        }
    }

    public function headAgentList(Request $request){
		$columns = array(0=>'id' , 1=>'f_name', 2=>'mobile', 3=>'name');
		$dir = $request->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
		else{ $dir = "DESC"; }
        $order = $columns[$request->input('order.0.column')];
        
        $query = Role::where([['name','=','head-agent']]);
                $query->join('role_user as ru',function($join){
                    $join->on('roles.id','=','ru.role_id');
                });
                $query->join('users as u',function($join){
                    $join->on('ru.user_id','=','u.id');
                });
        $partners = $query->select('u.*')->get();
      	$partners_lists = [];
		if($partners->count() > 0){
			$i = 1;
			foreach($partners as $partner){
				$features_list = [];
				$features_list['sn'] = '<a href="'.url("admin/users_allocation/agent_allocation/$partner->id").'">'.$partner->user_id.'<a/>';
				$features_list['name'] = sHelper::getFullName($partner);
				$features_list['login_id'] = $partner->login_id;
				$features_list['mobile'] = $partner->mobile;
				$features_list['action'] = "Action";
                $i++;
               
				$partners_lists[] = $features_list;
			}
		}

				$json_data = array(
                    "draw"            => intval(request()->input('draw')),  
                    "recordsTotal"    => intval($partners->count()),  
                    "recordsFiltered" => intval($partners->count()), 
                    "data"            => $partners_lists   
                );
                 return json_encode($json_data); exit;
    }
    

    /*list only agent users*/
    public function agentAllocation(Request $request){
        $headAgentID = $request->headAgentID;
       $columns = array(0=>'id' , 1=>'f_name', 2=>'mobile', 3=>'name');
		$dir = $request->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
		else{ $dir = "DESC"; }
        $order = $columns[$request->input('order.0.column')];

        $query = Role::where([['name','=','agent'],['head_agent_id','=',$headAgentID]])->orwhere([['name','=','agent'],['head_agent_id','=',NULL]]);
                $query->join('role_user as ru',function($join){
                    $join->on('roles.id','=','ru.role_id');
                });
                $query->join('users as u',function($join){
                    $join->on('ru.user_id','=','u.id');
                });
        $partners = $query->select('u.*')->get();
      /*   echo "<pre>";
        print_r($partners);exit; */
      	$partners_lists = [];
		if($partners->count() > 0){
            //echo $headAgentID;exit;
			$i = 1;
			foreach($partners as $partner){
                $features_list = [];
                /*selected unselected users */
                $selected_status = $check_exists = NULL;
                $check_exists = DB::table('users')->where([['id','=',$partner->id],['head_agent_id','=',$headAgentID]])->first();
                if($check_exists != NULL){
                    $selected_status = "Checked";
                } 
                $checkbox = '<div class="form-group">
                            <input type="checkbox" class="select_agent" value="'.$partner->id.'" '.$selected_status.' />
                        </div>';
                /*End*/
                $features_list['sn'] = $checkbox;
                $features_list['agentid'] =  '<a href="'.url("admin/edit_partner/$partner->id").'">'.$partner->user_id.'<a/>';
				$features_list['name'] = sHelper::getFullName($partner);
				$features_list['loginid'] = $partner->login_id;
				$features_list['mobile'] = $partner->mobile;
			    $i++;
                $partners_lists[] = $features_list;
			}
		}

             
				$json_data = array(
                    "draw"            => intval(request()->input('draw')),  
                    "recordsTotal"    => intval($partners->count()),  
                    "recordsFiltered" => intval($partners->count()), 
                    "data"            => $partners_lists   
                );
                 return json_encode($json_data); exit;
    }
    /*End*/
}
