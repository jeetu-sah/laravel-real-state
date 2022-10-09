<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     
	 
	
	*/

	public function __construct() {
        $this->middleware('guest')->except('/');
    }


	public function index(){
		$data['title'] = "Door Plus";
        if(! view()->exists('admin.login')){
           return view('404');
        }
        return view('admin.login')->with($data);
	}


	public function login(Request $request){
		/* echo "<pre>";
		print_r($request->all());exit; */
	    $validatedData = $request->validate(array(
			  'email' => 'required','password' => 'required'));
		/*matched users credential*/
		$user_details = User::where([['login_id','=',$request->email]])->first();
		/*End*/
		if($user_details != NULL){
			if($user_details->deleted_at == NULL){
				if(Hash::check($request->password, $user_details->password)){
					$remember = $request->remeber_me;
					Auth::login($user_details , $remember); 
					return redirect('/admin/dashboard')->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Login Successfully !!! </div>" ]);  
				   }
				else{
					 return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  password does not matched !!! </div>"]);  
				   }		
			}
			else{
			  return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Your account is blocked !!! </div>"]);
			}
		 }
		else{
		  return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again ,  User does not exists !!! </div>"]);
		} 
	}
	
	/*public function store(){
	  echo "<pre>";
	  print_r("yesss");exit;
	}*/
	
	
	
	
	
}
