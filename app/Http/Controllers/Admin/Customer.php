<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProofType , App\User;
use sHelper;
use App\Models\Role;
use Illuminate\Support\Str;
use Hash;

class Customer extends Controller
{
    
     public function page($page , $p1 = NULL){
        $data['title'] = "lakhmanis";
        /*Admin Un Read Notification*/
        $data['notifications'] = auth()->user()->unreadNotifications;
        $data['proofType'] = ProofType::all();
        if($page == "edit_customer"){
          $data['customerDeatil'] = User::find($p1);
        //   echo "<pre>";
        //   print_r($data['customerDeatil']);exit;
        }
        if($page == "create_customer"){
            $data['priority'] = User::max('id') + 1;
            $data['partnerID'] = sHelper::partnerID($data['priority']);
            $data['customerID'] = sHelper::customerID($data['priority']);
        }
        
		/*End*/
        if(! view()->exists("admin.customer.$page")){
           return view('admin.404');
        }
        return view("admin.customer.$page")->with($data);
    }


    public function createCustomer(Request $request){
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
                                    'password'=>Hash::make(trim($request->password)),
                                    'commission'=>$commission,
                                    'mobile_verified_at'=>now(),
                                    'proof'=>$image_name,
                                    'proof_url'=>$image_path,
                                    'roll_id'=>2,
                                    'user_status'=>'A',
                                    'term_and_condition_status'=>1,
                                    'priority'=>$request->priority,
                                    'description'=>$request->address,
                                    'proof_type_id'=>$request->proof_type, 
                                    'id_proof_number'=>$request->id_proof_number,
                                    'is_signed'=>1,
                                    'user_id'=>$request->partner_id,
                                    'login_id'=>$request->login_id,
                                    'hidden_user'=>0, 
                                    'customer_type'=>1,
                                    ]);
                   
                  
				if($response){
                    $role  = Role::where([['name','=','buyer']])->first();
                    $response->attachRole($role);
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
		}else{
			/*user already exists messages*/
				return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Login Id is already exists , !!! </div>"]); 
			/*End*/
		}
       
    }

    public function editCustomer(Request $request){
        $validatedData = $request->validate([
            'name' =>'required',
			'mobile' =>'required',
			'proof_type'=>'required',
			'id_proof_number'=>'required',
			'login_id'=>'required',
		]);
		/*users admin login */
        $userDeatail = User::find($request->editid);
        /*End*/
   
		if($userDeatail != NULL){
			/*xcheck mobile number or email exists*/
		        $image_name =$userDeatail->proof;
                $image_path = $userDeatail->proof_url;
				$upload_image = $this->upload_image($request);
				if(count($upload_image) > 0){
					$image_name = $upload_image[0];
					$image_path = $upload_image[1];
				}
				
                $response = $userDeatail->update(['f_name'=>$request->name,
                                    'user_name'=>Str::slug($request->name,'-'),
                                    'email'=>trim($request->email),
                                    'mobile'=>trim($request->mobile), 
                                    'password'=>Hash::make(trim($request->password)),
                                    'proof'=>$image_name,
                                    'proof_url'=>$image_path,
                                    'priority'=>$request->priority,
                                    'description'=>$request->address,
                                    'proof_type_id'=>$request->proof_type, 
                                    'id_proof_number'=>$request->id_proof_number,
                                    'user_id'=>$request->partner_id,
                                    'login_id'=>$request->login_id,
                                    ]);
                   
                  
				if($response){
                    return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Record save Successfully  !!! </div>"]); 
				}
				else{
					  return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
				}
			
			/*End*/
		}else{
			/*user already exists messages*/
				return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Login Id is already exists , !!! </div>"]); 
			/*End*/
		}
       
    }


}
