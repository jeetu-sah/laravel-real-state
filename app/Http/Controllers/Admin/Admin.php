<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Str;
use Auth;
use DB;
use App\Booking;
use Freshbitsweb\Laratables\Laratables;
use sHelper;
use Carbon\Carbon;
use App\ProofType;
use App\CommonFeatures;
use App\CountriesCities;
use App\User;
use App\Society;	
use App\Gallery;
use App\SocietyUsers;
use App\PlotPaymentHistory;
use Hash;
use App\Notifications\SignUp;
use Notification;
use App\Models\Role;
use App\Traits\AdminTraits;


class Admin extends Controller{
	use AdminTraits;

    public function index(){
		$data['title'] = "lakhmanis";
	
        /*Admin Un Read Notification*/
		$data['notifications'] = auth()->user()->unreadNotifications;
		/*End*/
        if(! view()->exists('admin.login')){
           return view('admin.404');
        }
        return view('admin.login')->with($data);
    }

    public function page($page = "dashboard" , $p1 = NULL){
		//Artisan::call('backup:run');
		$data['title'] = "lakhmanis - Admin | ".$page;
		$data['societies'] = SocietyUsers::where([['user_id','=',Auth::user()->id]])->count();
		/*Find number of agents*/
		/*Admin Un Read Notification*/
		$data['notifications'] = auth()->user()->unreadNotifications;
		if(Auth::check()){
			if(Auth::user()->hasRole('head-agent')){
				$data['agentList'] = User::where([['head_agent_id','=',Auth::user()->id]])->count();
			}
		}
		/*End */
		/*load all notification*/
		if($page == "notification"){
			$data['allNotifications'] = $this->allNotification();
		}
		/*End*/
		if($page == "dashboard"){
			$data['totalNumberOFSociety'] = Society::count();
			$data['totalNumberOFPayments'] = PlotPaymentHistory::count();
		}
		if($page == "partner_list"){
			 $data['roles'] = Role::all();
		}
	
		
		if($page == "add_society"){
			$data['priority']= Society::max('id') + 1;
			$data['partnerID'] = sHelper::societyID($data['priority']);
		}

		if($page == "edit_society"){
			$data['mapUrl'] = NULL;
			$data['societyDetails'] =  Society::with(['society_map'])->find($p1);
			if($data['societyDetails'] != NULL){
				$data['societyMap'] = $data['societyDetails']->first();
				if($data['societyMap'] != NULL){
					$data['mapUrl'] = $data['societyMap']->image_name_url; 
				}
			}
		}
		if($page == "allocate_society"){
			if(empty($p1)){ return redirect()->back(); }
			$data['societyDetails'] =  Society::with(['society_map'])->find($p1);
		
		}
		if($page == "societyImage"){
			if(empty($p1)){ return redirect()->back(); }
			$data['societyID'] = $p1;
			$data['societyImage'] =  Gallery::where([['societiy_id','=',$p1],['type','=',2]])->get();
		}
		if($page == "hotel_lists"){
            if(empty($p1)){ return redirect()->back(); }
             $data['hotels'] = HotelRestaurant::where('hotel_restaurant_token_id',$p1)->get();
        }
		if($page == "remove_partners"){
			$user = User::find($p1);
		   if($user != NULL){
			   $user->deleted_at = now();
			   if($user->save()){
				  return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Record delete Successfully  !!! </div>"]); 
				 }
			    else{
				  return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
				}	 
			 }
		}
		if($page == "remove_society"){
			$society = Society::find($p1);
			if($society != NULL){
			   $society->deleted_at = now();
			   if($society->save()){
				  return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Record delete Successfully  !!! </div>"]); 
				 }
			    else{
				  return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
				}	 
			 }
		}

		/*edit users credential*/
		if($page == "edit_credential"){
			if(Auth::user()->isAbleTo('change-user-credential')){
				if(!empty($p1)){
					$data['userDetail'] = User::find($p1);
				}
			}
		}
		/*End*/
		
		if(! view()->exists("admin.pages.$page")){
           return view('admin.404');
        }
        return view("admin.pages.$page")->with($data);
    }

	public function partner($page ,$p1 = NULL){
		$data['title'] = "lakhmanis - Admin | ".$page;
		/*Admin Un Read Notification*/
		$data['notifications'] = auth()->user()->unreadNotifications;
		if(Auth::check()){
			if(Auth::user()->hasRole('head-agent')){
				$data['agentList'] = User::where([['head_agent_id','=',Auth::user()->id]])->count();
			}
		}
		/*End */
		if($page == "add_partner"){
			$data['priority'] = User::max('id') + 1;
			$data['proofType'] = ProofType::all();
			$data['partnerID'] = sHelper::partnerID($data['priority']);
		}
		if($page == "edit_partner"){
			//$data['priority']= CommonFeatures::max('id');
			if(empty($p1)){ return redirect()->back(); }
			$data['proofType'] = ProofType::all();
			$data['partner'] = User::find($p1);
		}
		
		if(! view()->exists("admin.pages.$page")){
           return view('admin.404');
        }
        return view("admin.pages.$page")->with($data);
	}

    public function edit_partners(Request $request){
		$commission = 0;
		$validatedData = $request->validate([
            'name' =>'required',
			'mobile' =>'required',
			'proof_type'=>'required',
			'id_proof_number'=>'required',
			'editid'=>'required'
		]);
		$userDetails = User::find($request->editid);
		if($userDetails != NULL){
			$proof = $userDetails->proof;
			$proof_url = $userDetails->proof_url;
			/*upload proof file start*/
			if(!empty($request->image)){
				$upload_image = $this->upload_image($request);
				if(count($upload_image) > 0){
					$proof = $upload_image[0];
					$proof_url = $upload_image[1];
				}
			}
			/*End*/
			if(!empty($request->commission_percentage)){
				$commission = $request->commission_percentage;
			}
			$response = $userDetails->update(['f_name'=>$request->name,
										'user_name'=>Str::slug($request->name, '-'),
										'email'=>trim($request->email),
										'commission'=>$commission,
										'mobile'=>trim($request->mobile), 
										'proof'=>$proof,
										'proof_url'=>$proof_url,
										'roll_id'=>2,
										'user_status'=>'A',
										'term_and_condition_status'=>1,
										'priority'=>$request->priority,
										'description'=>$request->description,
										'proof_type_id'=>$request->proof_type, 
										'id_proof_number'=>$request->id_proof_number,
										'is_signed'=>'1',
										'user_id'=>$request->partner_id,
										]);

		  
			if($response){
				return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Record Updated Successfully  !!! </div>"]); 
			}
			else{
				  return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
			}

		}else{
			return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , Partners details not found !!! </div>"]); 
		}
    }

    public function add_society(Request $request){
		$image_name = $image_path = $societyPdfMapName = $societyPdfmapurl = NULL;
    	$validatedData = $request->validate([
			'name' =>'required',
			'number_of_plots'=>'required|integer',
			'priority'=>'required',
			'location'=>'required'
		]);
		/*upload society image*/
		$uploadSocietyImage = [];
	
		/*upload society map pdf*/
		if($request->has('society_pdf_map')){
			$societyPdfMap = $this->societyPdfMap($request);
			if($societyPdfMap[0] == 200){
				$societyPdfMapName = $societyPdfMap[1];
				$societyPdfmapurl = $societyPdfMap[2];
			}
		}
		/*End*/
		if ($request->has('spcity_photos')) {
			/*upload society photos*/
			$uploadSocietyImage = $this->societyImage($request);
			/*End*/
		}
		/*End*/
    	if(!empty($request->image)){
			$upload_image = $this->society($request);
			if(count($upload_image) > 0){
				if($upload_image[0] == 100){
					return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'>
					<strong>Wrong </strong> File format not supported , Support only PDF , DOCS file .</div>"]); 
				}
			}
			$image_name = $upload_image[1];
			$image_path = $upload_image[2];
		}


		$response = Society::create(['name'=>$request->name,
									 'slug_name'=>str::slug($request->name,'-'),
									 'location'=>$request->location,
									 'number_of_plots'=>$request->number_of_plots,
									 'priority'=>$request->priority,
									 'society_id'=>$request->society_id,
									 'society_pdf_map_name'=>$societyPdfMapName,
									 'society_pdf_map_url'=>$societyPdfmapurl,
									]);
		if($response){
			/*upload society map*/
			if(!empty($image_name)){
            	Gallery::create(['societiy_id'=>$response->id, 
								'image_name'=>$image_name, 
								'type'=>1,
								'image_name_url'=>$image_path]);
			}
			/*End*/
			/*upload society image*/
			if(count($uploadSocietyImage) > 0){
				foreach($uploadSocietyImage as $societyImage){
					Gallery::create(['societiy_id'=>$response->id, 
								'image_name'=>$societyImage[0],
								'type'=>2,
								'image_name_url'=>$societyImage[1]]);
				}
			}
			/*End*/
            return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Society Record Successfully  !!! </div>"]); 
        }
        else{
              return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
        }
    }

    public function edit_society(Request $request){
		$image_name = $image_path = $societyPdfMapName = $societyPdfmapurl = NULL;
    	$validatedData = $request->validate([
			'name' =>'required',
			'editid'=>'required',
			'number_of_plots'=>'required',
			'priority'=>'required',
			'location'=>'required'
		]);
		$societyDetails = Society::with(['society_map'])->find($request->editid);
		if($societyDetails != NULL){
		 	if(!empty($request->image)){
				$upload_image = $this->society($request);
				if(count($upload_image) > 0){
					if($upload_image[0] == 100){
						return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'>
						<strong>Wrong </strong> File format not supported , Support only PDF , DOCS file .</div>"]); 
					}
				}
				$image_name = $upload_image[1];
				$image_path = $upload_image[2];
			}

			/*upload society map pdf*/
			if($request->has('society_pdf_map')){
				$societyPdfMap = $this->societyPdfMap($request);
				if($societyPdfMap[0] == 200){
					$societyPdfMapName = $societyPdfMap[1];
					$societyPdfmapurl = $societyPdfMap[2];
				}
			}else{
				$societyPdfMapName = $societyDetails->society_pdf_map_name;
				$societyPdfmapurl = $societyDetails->society_pdf_map_url;
			}
			/*End*/

			$response = Society::where([['id','=',$request->editid]])
										->update(['name'=>$request->name,
										 'slug_name'=>str::slug($request->name,'-'),
										 'location'=>$request->location,
										 'number_of_plots'=>$request->number_of_plots,
										 'priority'=>$request->priority,
										 'society_id'=>$request->society_id,
										 'society_pdf_map_name'=>$societyPdfMapName,
										 'society_pdf_map_url'=>$societyPdfmapurl,
										]);
			if($response){
				if(!empty($image_name)){
					if(!empty($request->image)){
						/*First delete all map related this society*/
						Gallery::where([['societiy_id','=',$request->editid] , ['type','=',1]])->delete();
						/*End*/
						Gallery::create(['societiy_id'=>$request->editid, 
										'image_name'=>$image_name,
										'type'=>1, 
										'image_name_url'=>$image_path]);
					}
				}
				return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Record update Successfully  !!! </div>"]); 
			}
			else{
				  return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
			}
		}else{
			return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
		}
       
	}
	

	/*upload society image*/
	public function uploadSocietyImage(Request $request){
		if(!empty($request->societyID)){
			$uploadSocietyImage = [];
			if ($request->has('spcity_photos')) {
				/*upload society photos*/
				$uploadSocietyImage = $this->societyImage($request);
				 /*End*/
			}
			if(count($uploadSocietyImage) > 0){
				foreach($uploadSocietyImage as $societyImage){
					Gallery::create(['societiy_id'=>$request->societyID, 
								'image_name'=>$societyImage[0],
								'type'=>2,
								'image_name_url'=>$societyImage[1]]);
				}
				return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'>
			<strong>Wrong </strong>  Image Upload successfully  !!! </div>"]); 
			}
		}else{
			return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'>
			<strong>Wrong </strong>  Something went wrong , please try again  !!! </div>"]); 
		}

	}
	/*End*/
	
	
    public function add_partners(Request $request){
		$commission = 0;
		$validatedData = $request->validate([
            'name' =>'required',
			'mobile' =>'required',
			'proof_type'=>'required',
			'id_proof_number'=>'required',
			'login_id'=>'required',
			'password'=>'required'
		]);
		/*users admin login */
		$checkUserID = User::where([['login_id','=',$request->login_id]])->first();
		/*End*/
		if($checkUserID == NULL){
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
				if(!empty($request->commission_percentage)){
					$commission = $request->commission_percentage;
				}
						$response = User::create(['f_name'=>$request->name,
											'user_name'=>Str::slug($request->name, '-'),
											'email'=>trim($request->email),
											'email_verified_at'=>now(),
											'mobile'=>trim($request->mobile), 
											'password'=>Hash::make(trim($request->password)),
											'commission'=>$commission,
											'mobile_verified_at'=>now(),
											'proof'=>$image_name,
											'proof_url'=>$image_path,
											'roll_id'=>2,
											'user_status'=>'A',
											'term_and_condition_status'=>1,
											'priority'=>$request->priority,
											'description'=>$request->description,
											'proof_type_id'=>$request->proof_type, 
											'id_proof_number'=>$request->id_proof_number,
											'is_signed'=>1,
											'user_id'=>$request->partner_id,
											'login_id'=>$request->login_id,
											'hidden_user'=>0, 
											]);
				if($response){
					if(!empty($response->email)){
						Notification::send($response, new SignUp($response));
					}
					return redirect("admin/roles/user_permission/$response->id?page=roles")->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Record save Successfully  !!! </div>"]); 
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
		}else{
			/*user already exists messages*/
				return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Login Id is already exists , !!! </div>"]); 
			/*End*/
		}
       
    }
	
	
	public function allocate_deallocate_society_to_partner(){
	   if(!empty(request()->userID)){
            /*find user details*/
			$userDetail = User::find(request()->userID);
			/*End*/
            if($userDetail != NULL){
                /*allocate roles*/
                if(request()->action == "allocate"){
					$saveResponse = SocietyUsers::create(['user_id'=>$userDetail->id , 'society_id'=>request()->societyID]);
					if($saveResponse){
						echo "<div class='notice notice-success notice'><strong>Success </strong>  Society Allocated !!! </div>";exit;
					}else{
						echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit;
					}
                }
                /*End*/
                /*de allocate roles*/
                if(request()->action == "deallocate"){
				   $deleteResponse = SocietyUsers::where([['user_id','=',$userDetail->id],['society_id','=',request()->societyID]])->delete();
				   if($deleteResponse){
						echo "<div class='notice notice-success notice'><strong>Success </strong>  Society De-Allocated !!! </div>";exit;
					}else{
						echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit;
					}
                }
                /*End*/
            }else{
				echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit;
			}
    
        }else{
           echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit;
        }
       
    }
	
	
	
	
	public function removeSocietyImage($p1){
		if(!empty($p1)){
			$societyImage = Gallery::find($p1);
			if($societyImage != NULL){
				if($societyImage->delete()){
					return redirect()->back()->with(['status'=>200 , 'msg'=>"<div class='notice notice-success notice'><strong>Success </strong>Image remove successfully !!! </div>"]);   
				}else{
					return redirect()->back()->with(['status'=>100 , 'msg'=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]);   
				}
			}
		}else{
			return redirect()->back()->with(['status'=>100 , 'msg'=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]);   
		}
	}
	


    public function logout(){
	   $user = Auth::user();
	   Auth::logout($user);
	   return redirect('/admin-login');
	}

	public function change_credential(Request $request){
		$validatedData = $request->validate([
            'user_id' =>'required',
			'login_id' =>'required',
			'password'=>'required',
		]);
		$checkLoginID = User::where([['login_id','=',$request->login_id]])->first();
		if($checkLoginID == NULL){
			$userDetails = User::where([['id','=',$request->user_id]])->update(['login_id'=>$request->login_id,
			  													   'password'=>Hash::make(trim($request->password)),
																	]);
			if($userDetail){
				return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Credential change successfully  , !!! </div>"]); 
			}else{
				return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something went wrong , please try again !!! </div>"]); 
			}
		}else{
			$chgangeCredential = User::where([['id','=',$request->user_id]])
										->update(['password'=>Hash::make(trim($request->password))]);
			if($chgangeCredential){
				return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Password change successfully  , !!! </div>"]); 
			}else{
				return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something went wrong , please try again !!! </div>"]); 
			}
		}
		
	}

	public function hotel_status(Request $request){
		//print_r($request->all());exit;
		$exp = explode('@',$request->stats);
		//print_r($exp[1]);exit;
		$hotel_detail = HotelRestaurant::find($exp[1]);
		//print_r($hotel_detail);exit;
		$response = $hotel_detail->update([
              'status' => $exp[0]
		]);
		if($response){
			return json_encode(['status'=>200 , 'msg'=>"Status updated successfully ."]);                  
	                                
	        }else{
	          return json_encode(['status'=>100 , 'msg'=>"Something , went wrong , please try again !!!"]);
	        }
	}
	
    
}
