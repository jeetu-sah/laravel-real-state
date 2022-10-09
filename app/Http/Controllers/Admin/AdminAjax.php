<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use sHelper;
use App\Society;
use DB;
use Auth;
use App\Models\Role;

class AdminAjax extends Controller{
	
	
    public function partnerlist(Request $request){
		$limit = request()->input('length');
		$start = request()->input('start');
	
		$columns = array(0=>'created_at' , 1=>'f_name', 2=>'mobile', 3=>'name');
		$dir = $request->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
		else{ $dir = "DESC"; }
		$order = $columns[$request->input('order.0.column')];
		if(!empty($request->roles)){
			/*End*/
			$partners = collect();			
			$roleDetails = Role::where([['name','=',trim($request->roles)]])->first();
			if($roleDetails != NULL){
				$userIDArr =  DB::table('role_user')->where([['role_id','=',$roleDetails->id]])->pluck('user_id')->toArray();
				if(count($userIDArr) > 0){
					$partnerQuery = User::with(['proofType'])->orderBy($order,$dir)->where([['roll_id','=',2]])->whereIn('id',$userIDArr);
					$totalRecord = $partnerQuery->count();
					$partners = $partnerQuery->skip($start)->take($limit)->get();
				
				}
			}
			/*End*/
		}else{
			$partnerQuery = User::with(['proofType'])->orderBy($order,$dir)->where([['roll_id','=',2]]);
			$totalRecord = $partnerQuery->count();
			$partners = $partnerQuery->skip($start)->take($limit)->get();
		}
		

		$partners_lists = [];
		if($partners->count() > 0){
			$i = 1;
			foreach($partners as $partner){
				$change_credential = NULL;	
				$delete_btn =  "<a href='javascript::void()' data-partnerid='".$partner->id."' data-toggle='tooltip' title='Add category' class='btn btn-danger remove_partner' style='margin-right: 5px;'><i class='fas fa-trash'></i></a>&nbsp;";
				if($partner->customer_type != 1){
					$edit_btn = '<a href="'.url("admin/partner/edit_partner/".$partner->id).'" data-toggle="tooltip" title="Edit Record" class="btn btn-primary" style="margin-right: 5px;">
						<i class="fas fa-edit"></i> 
					  </a>';
				}else{
						$edit_btn = '<a href="'.url("customer/edit_customer/".$partner->id).'" data-toggle="tooltip" title="Edit Record" class="btn btn-primary" style="margin-right: 5px;">
						<i class="fas fa-edit"></i> 
					  </a>';	
				}
				
				if(Auth::user()->isAbleTo('change-user-credential')){
					$change_credential = '<a href="'.url("admin/edit_credential/".$partner->id).'" data-toggle="tooltip" title="Edit Record" class="btn btn-success" style="margin-right: 5px;">
						<i class="fas fa-key"></i> 
					  </a>';	
				}
				$features_list = [];
				$features_list['sn'] = '<a href="'.url("admin/roles/user_permission/$partner->id?page=roles").'">'.$partner->user_id.'</a>'; ;

				$features_list['name'] = sHelper::getFullName($partner);
				$features_list['login_id'] = $partner->login_id;
				$features_list['mobile'] = $partner->mobile;
				$features_list['proofType'] = $partner->proofType->name;
				$features_list['proofNumber'] = $partner->id_proof_number;
				$features_list['action'] = $delete_btn.' '.$edit_btn." ".$change_credential;
				$i++;
				$partners_lists[] = $features_list;
			}
		}

				$json_data = array(
                    "draw"            => intval(request()->input('draw')),  
                    "recordsTotal"    => intval($totalRecord),  
                    "recordsFiltered" => intval($totalRecord), 
                    "data"            => $partners_lists   
                );
                 return json_encode($json_data); exit;
	}

	public function scietyList(){
		$columns = array(0=>'id', 1=>'name', 2=>'number_of_plots', 3=>'society_id');
		$dir = request()->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
		else{ $dir = "DESC"; }
		$order = $columns[request()->input('order.0.column')];
		$societies = Society::with(['society_map'])->orderBy($order,$dir)->get();
		$society_list = [];
		if($societies->count() > 0){
			foreach($societies as $society){
				$delete_btn =  "<a href='javascript::void()' data-societyid='".$society->id."' data-toggle='tooltip' title='Add category' class='btn btn-danger remove_society' style='margin-right: 5px;'><i class='fas fa-trash'></i></a>&nbsp;";
				$edit_btn = '<a href="'.url("admin/edit_society/".$society->id).'" data-toggle="tooltip" title="Edit Record" class="btn btn-primary" style="margin-right: 5px;">
                    <i class="fas fa-edit"></i> 
				  </a>';
				$imageBtn = '<a href="'.url("admin/societyImage/".$society->id).'" data-toggle="tooltip" title="Edit Record" class="btn btn-warning" style="margin-right: 5px;" target="_blank">
                    <i class="fas fa-image"></i> 
				  </a>';
				$mapCollection = $society->society_map->where('type',1);
				$mapDetail = $mapUrl = $pdfMapUrl = NULL;
				if($mapCollection->count() > 0){
					$mapDetail = $mapCollection->first();
					if($mapDetail != NULL){
						$mapUrl = $mapDetail->image_name_url;
					}
				}
				if($mapUrl != NULL){
					$mapUrl = '<a target="_blank" href="'.$mapUrl.'">Click To View</a>'; 
				}
				if(!empty($society->society_pdf_map_url)){
					$pdfMapUrl = '<a target="_blank" href="'.$society->society_pdf_map_url.'">Click To View</a>'; 
				}
				
				$societyArr = [];
				$societyArr['id'] =  '<a href="'.url("admin/allocate_society/".$society->id).'">'.$society->society_id.'<a/>';
				$societyArr['name'] = $society->name;
				$societyArr['map'] = $mapUrl;
				$societyArr['pdfmap'] = $pdfMapUrl;
				$societyArr['numberOfPlots'] = $society->number_of_plots;
				$societyArr['priority'] = $society->priority;
				$societyArr['location'] = $society->location;
				$societyArr['action'] = $delete_btn.' '.$edit_btn.' '.$imageBtn;
				$society_list[] = $societyArr;
			}
		}
		$json_data = array(
			"draw"            => intval(request()->input('draw')),  
			"recordsTotal"    => intval($societies->count()),  
			"recordsFiltered" => intval($societies->count()), 
			"data"            => $society_list   
		);
		return json_encode($json_data); exit;
		
	}



	public function usersList(){
        $columns = [0=>'id',1=>'id' , 2=>'f_name',3=>'mobile',4=>'email'];
        $dir = request()->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
        else{ $dir = "DESC"; }
        $order = $columns[request()->input('order.0.column')];
        $users_list = [];
        $users = User::where([['roll_id','=',2]])->get();
        if($users->count() > 0){
			$societyID = request()->societyID;
            foreach($users as $key=>$user){
				/*Checked unchecked*/
				$selected_status = NULL;
                $check_exists = DB::table('society_users')->where([['user_id','=',$user->id],['society_id','=',$societyID]])->first();
                if($check_exists != NULL){
                    $selected_status = "Checked";
				} 
				/*End*/
                $user_id = sHelper::partnerID($user->id);
                $userTab = '<a href="'.url("admin/partner_list").'">'.$user_id.'</a>';
                $user_arr = [];
				$user_arr['sn'] = '<input type="checkbox" class="allocateSociety" value="'.$user->id.'" '.$selected_status.'>';
				$user_arr['userid'] = $userTab;
				$user_arr['name'] = sHelper::getFullName($user);
				$user_arr['mobile'] = $user->mobile;
				$user_arr['email'] = $user->email;
                $users_list[] = $user_arr;
            }
        }
        $json_data = array( "draw" => intval(request()->input('draw')),  
                            "recordsTotal" => intval($users->count()),  
                            "recordsFiltered" => intval($users->count()), 
                            "data"=> $users_list   
                         );
        return json_encode($json_data); exit;
    }
}
