<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Illuminate\Support\Str;
use App\SocietyUsers;
use App\User;
use App\ProofType;
use App\Society;
use App\SpcietyRooms;
use App\SocietyPlotsNumber;
use sHelper;

class Partners extends Controller
{
    
    public function page($page = NULL , $p1 = NULL){
		$data['title'] = "Lakhmanis | Partner - $page";
		if(!Auth::check()){ return redirect('/'); }
		$data['notifications'] = auth()->user()->unreadNotifications;
        /*find Society which allocated to users*/
        $data['societies'] = SocietyUsers::where([['user_id','=',Auth::user()->id]])->count();
        if($page == "societies"){
             $data['societies'] = SocietyUsers::where([['user_id','=',Auth::user()->id]])->get();
        }
        if($page == "agents"){
            $data['agents'] = User::where([['partner_id','=',Auth::user()->id]])->get();
        }
        if($page == "add_agent"){
            $data['priority'] = User::max('id') + 1;
            $data['proofType'] = ProofType::all();
            $data['partnerID'] = sHelper::partnerID($data['priority']);
        }
		/*End*/
		if($page == "block"){
			if(empty($p1)){	return redirect()->back(); }
			$data['societyDetails'] = Society::find($p1);
		}
		if($page == "plots"){
			$data['societyDetails'] = NULL;
			if(empty($p1)){	return redirect()->back(); }
			$p1 = (int) $p1;
			$data['blockDetail'] = SpcietyRooms::find($p1);
			if($data['blockDetail'] != NULL){
				$data['societyDetails'] = Society::find($data['blockDetail']->society_id);
			}
			
		}
		
        /*load view for partner*/
        if(! view()->exists("admin.partner.$page")){
           return view('admin.404')->with($data);
        }
       return view("admin.partner.$page")->with($data);
    }

    public function blockList(){
		$columns = [0=>'title' , 1=>'room_area', 2=>'plot_size_by_gaj', 3=>'plot_value',4=>'title'];
		$dir = request()->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
		else{ $dir = "DESC"; }
        $order = $columns[request()->input('order.0.column')];
        $societyID = request()->input('societyid');
		$searchKeyWord = request()->input('search.value');
		$blockQuery =  SpcietyRooms::where([['society_id','=',$societyID]]);
						if(!empty($searchKeyWord)){
						 $blockQuery->Where('title','like','%'.$searchKeyWord.'%');
						}
		$societyRooms = $blockQuery->orderBy($order,$dir)->get();	
		$roomsList = collect();
		if($societyRooms->count() > 0){
			$i = 1;
			foreach($societyRooms as $room){
				$change_credential = NULL;	
				$edit_btn = '<a href="'.url("partner/plots/".$room->id).'" data-toggle="tooltip" title="Number of Plots" class="btn btn-primary" style="margin-right: 5px;">
                   <i class="fas fa-list"></i> Numbers of Plots 
				  </a>';
				$roomList = [];
				$roomList['sn'] = $room->id;
				$roomList['title'] = '<a href="'.url("partner/plots/$room->id").'" target="_blank">'.$room->title.'</a>';
				$roomList['plot_size_by_gaj'] = $room->plot_size_by_gaj;
				$roomList['number_of_plot'] = $room->number_of_plot;
				$roomList['action'] = $edit_btn;
				$i++;
				$roomsList[] = $roomList;
			}
		}

        $json_data = array(
            "draw"            => intval(request()->input('draw')),  
            "recordsTotal"    => intval($roomsList->count()),  
            "recordsFiltered" => intval($roomsList->count()), 
            "data"            => $roomsList   
        );
        return json_encode($json_data); exit;
	}



	public function plotNumberList(){
		$plotNumberObj = new SocietyPlotsNumber;
        $plotsBookingStatusArr = $plotNumberObj->plotBookingStatuForAgent;
	    $searchKeyWord = NULL;
        if(!empty(request()->input('search.value'))){
            $searchKeyWord = request()->input('search.value');
        }
        $blockID = request()->bloclID;
        $columns = [0=>'id', 2=>'plot_number', 3=>'plot_value', 4=>'booking_status'];
        $dir = request()->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
        else{ $dir = "DESC"; }
        $order = $columns[request()->input('order.0.column')];
        $plotList = [];
        $query = SocietyPlotsNumber::where([['society_plot_id','=',$blockID]]);
                    if(!empty($searchKeyWord)){
                        $query->Where('plot_number','like','%'.$searchKeyWord .'%');
                    }
		$plotsNumberResponse = $query->orderBy('priority','ASC')->get();
	    if($plotsNumberResponse->count() > 0){
            $societyID = request()->societyID;
            $i = 1;
            foreach($plotsNumberResponse as $key=>$plotsNumber){
				$bookingStatus = "Not Defined";
				$labelColor = sHelper::returnBookingColor($plotsNumber->booking_status);
				/*set the plots label according to booking status */
				if(array_key_exists($plotsNumber->booking_status ,$plotsBookingStatusArr) ){
					$bookingStatus = "<label class='".$labelColor[0]."'>".$plotsBookingStatusArr[$plotsNumber->booking_status]."</label>";
				}
				/*End*/

                /*action button*/
               /* $actionBtn =  '<a data-plotid="'.$plotsNumber->id.'" href="javascript::void()" data-toggle="tooltip" title="Edit Plot Detail" class="btn btn-warning float-right editPlotDetails" style="margin-right: 5px;">
                <i class="fas fa-edit"></i>
                </a>';
              
                $actionBtn .= '<a target="_blank" href="'.url("admin/plots/plotDetail/$plotsNumber->id").'" data-toggle="tooltip" title="Check Plot Booking Detail" class="btn btn-primary float-right" style="margin-right: 5px;"> <i class="fas fa-info"></i></a>';*/
				/*End*/
				
                /*Checked unchecked*/
				$bookingStatusOption = '<select class="form-control booking_status" name="booking_status" data-plotnumber="'.$plotsNumber->id.'">';
						foreach($plotsBookingStatusArr as $key=>$plotsBookingStatus){
							$bookingStatusOption .= '<option value="'.$key.'"'. (($plotsNumber->booking_status == $key) ? "selected" : " ") .'>'.$plotsBookingStatus .'</option>';
						}                
				$bookingStatusOption .='</select>';
				if(!empty($plotsNumber->broker_id)){
					if(Auth::check()){
						if($plotsNumber->broker_id == Auth::user()->id){
							$bookingDropDownOption = $bookingStatusOption;
						}else{
							$bookingDropDownOption = "Booked";
						}
					}
				}else{
					$bookingDropDownOption = $bookingStatusOption;
				}
				/*End*/
                $plot_arr = [];
				$plot_arr['sn'] = $i;
				$plot_arr['plot_number'] = $plotsNumber->plot_number;
				$plot_arr['plot_value'] = $plotsNumber->plot_value;
				$plot_arr['complete_booking_status'] = $bookingStatus;
				$plot_arr['booking_status'] = $bookingDropDownOption;
				$plot_arr['plot_size'] = $plotsNumber->plot_size_in_gaj ?? 0;
				$plot_arr['plot_area'] = $plotsNumber->plot_area ?? 0;
				//$plot_arr['action'] = $actionBtn;
                $plotList[] = $plot_arr;
                $i++;
            }
        }
        $json_data = array( "draw" => intval(request()->input('draw')),  
                            "recordsTotal" => intval($plotsNumberResponse->count()),  
                            "recordsFiltered" => intval($plotsNumberResponse->count()), 
                            "data"=> $plotList   
                         );
        return json_encode($json_data); exit;
    }

    /*save agents*/
    public function add_agents(Request $request){
        $validatedData = $request->validate([
            'name' =>'required',
			'mobile' =>'required',
			'proof_type'=>'required',
			'id_proof_number'=>'required',
		]);
		/*xcheck mobile number or email exists*/
		$mobileUserExists = User::where([['mobile','=',$request->mobile]])->first();
		if($mobileUserExists == NULL){
			/*Email check */
			if(!empty($request->email)){
				$emailUserExists = User::where([['email','=',$request->email]])->first();
				if($emailUserExists != NULL){
					return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Email is already exists , !!! </div>"]); 
				}
			}
			/*End*/
			$image_name = $image_path = NULL;
			$upload_image = $this->upload_image($request);
			if(count($upload_image) > 0){
				$image_name = $upload_image[0];
				$image_path = $upload_image[1];
			  }
				   $response = User::create(['f_name'=>$request->name,
										'user_name'=>Str::slug($request->name, '-'),
										'email'=>trim($request->email),
										'email_verified_at'=>now(),
										'mobile'=>trim($request->mobile), 
										'password'=>Hash::make(trim($request->mobile)),
										'mobile_verified_at'=>now(),
										'proof'=>$image_name,
										'proof_url'=>$image_path,
										'roll_id'=>4,
										'user_status'=>'A',
										'term_and_condition_status'=>1,
										'priority'=>$request->priority,
										'description'=>$request->description,
										'proof_type_id'=>$request->proof_type, 
										'id_proof_number'=>$request->id_proof_number,
										'is_signed'=>'1',
                                        'user_id'=>$request->partner_id,
                                        'partner_id'=>Auth::user()->id
										]);
			
			
			
			if($response){
				return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Record save Successfully  !!! </div>"]); 
			}
			else{
				  return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
			}
		}else{
			/*user already exists messages*/
  			return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Mobile number is already exists , !!! </div>"]); 
			/*End*/
		}
		/*End*/
       
    }
    /*End*/
}
