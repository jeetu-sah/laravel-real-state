<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Category;
use App\CountriesCities;
use App\Gallery;
use App\HotelRestaurant;
use sHelper;
use App\Society;
use App\User;
use App\Models\Role;
use App\SocietyPlotsNumber;
use App\Events\PlotsBookingEvent;
use Auth;
use Notification;
use App\Notifications\PlotsStatus;
use App\Traits\HomeTraits;
use App\PlotPaymentHistory;
use Illuminate\Support\Str;

class Home extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use HomeTraits;
    
    public function index($page = "index" , $p1 = NULL){
        $data['title'] = "Lakhmanis | $page"; 
        /*show hotels list by searching*/
        /*gallery page load */
        if($page == "index"){
            $data['societies'] = Society::with(['society_map'])->where([['status','=','A']])->get();
        }
        if($page == "society"){
            if(empty($p1)){ return redirect()->back(); }
             $data['society'] = Society::with(['society_map'])->find($p1);
             if($data['society'] != NULL){
                 $data['societyMap'] = $data['society']->society_map->where('type',1)->first();
             }
        }
        if($page == "gallery"){
            $data['societies'] = Society::with(['society_map'])->get();
            if($data['societies']->count() > 0){
                if(empty($p1)){
                    $data['mainSociety'] = $data['societies']->first();
                }
            }
        
        }
        /*End*/
        if($page == "societies"){
           $data['societies'] = $this->societies();
        }
        if($page == "blocks"){
            $data['societyBlocks'] = $this->societyBlocks($p1);
        }
        if($page == "plot-number"){
            $data['societyBlocksPlots'] = $this->societyBlocksPlots($p1);
            if($data['societyBlocksPlots'] != NULL){
                $data['bookingStatusArr'] =  $data['societyBlocksPlots']->bookingStatusArr;
            }
            //echo "<pre>";
            //print_r($data['bookingStatusArr']);exit;
        }
        //echo $page;exit;
        if(! view()->exists("site.$page")){
           return view('site.404')->with($data);
        } 
       return view("site.$page")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(){
        $data['nav_country_city'] = collect();
        $data['title'] = "Door Plus"; 
        $data['country_city'] = CountriesCities::with(['gallery'])->City()->orderBy('priority','ASC')->get();
        if($data['country_city']->count() > 0){
            $data['nav_country_city'] = $data['country_city']->take(10);
        }
        /*show hotels list by searching*/
        /*show hotels list by searching*/
        /*find Hotels from location*/
        $data['hotels'] = HotelRestaurant::with(['hotels_restaurant_gallery','hotels_restaurant_features'])->get();
        /*End*/
        if(! view()->exists("users.hotels")){
            return view('users.404')->with($data);
        }
       return view("users.hotels")->with($data);
    }

  

	public function pages($page = "index" , $p1 = NULL){
       $data['title'] = "Doyca Rooms";	
       $data['title'] = "Door Plus"; 
        $data['nav_country_city'] = collect();
        $data['country_city'] = CountriesCities::with(['gallery'])->City()->orderBy('priority','ASC')->get();
        if($data['country_city']->count() > 0){
            $data['nav_country_city'] = $data['country_city']->take(10);
        }
       if(! view()->exists('users.$page')){
           return view('users.404');
       }
       return view('users.$page')->with($data);
    }
    
    
    public function states(){
		if(!empty(request()->countryid)){
            $option = '<option value="0">Select States</option>';
            $states = CountriesCities::where([['parent_id','=',request()->countryid] ,['state','=',0]])->get();
            if($states->count() > 0){
                foreach($states as $state){
                    $selected = NULL;
                    if($state->id == request()->state){
                        $selected = "Selected";
                    }
                    $option .= '<option value="'.$state->id.'" '.$selected.'>'.$state->name.'</option>'; 
                }
            }else{
                 $option .= '<option value="0">No State available !!!</option>'; 
            }
            return json_encode(['status'=>200 , 'state'=>$option]);
        }
    }


    /*find cities*/
    public function cities(){
        if(!empty(request()->state)){
            $option = '<option value="0">Select City</option>';
            $cities = CountriesCities::where([['state','=',request()->state] ,['parent_id','!=',0]])->get();
            if($cities->count() > 0){
                foreach($cities as $city){
                    $selected = NULL;
                    if($city->id == request()->city){
                        $selected = "Selected";
                    }
                    $option .= '<option value="'.$city->id.'" '.$selected.'>'.$city->name.'</option>'; 
                }
            }else{
                 $option .= '<option value="0">No State available !!!</option>'; 
            }
            return json_encode(['status'=>200 , 'state'=>$option]);
        }
    }
    /*End*/


    public function saveStatusOfplots(){
        $plotNumberObj = new SocietyPlotsNumber;
        $plotNumberStatus = $plotNumberObj->plotBookingStatuName;
        $holdDate = NULL;
        if(Auth::check()){
            if(!empty(request()->plotNumberID)){
                if(!empty(request()->statusID)){
                    if(request()->statusID == 2){
                        if(empty(request()->holdDate)){
                            return json_encode(['status'=>100 , "msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Hold Date is required !!! </div>"]);
                        }else{
                            $holdDate = request()->holdDate;
                        }
                    }
                    $plotDetail = SocietyPlotsNumber::find(request()->plotNumberID);
                    if($plotDetail != NULL){
                        $response = SocietyPlotsNumber::where([['id','=',request()->plotNumberID]])
                                                            ->update(['user_id'=>Auth::user()->id , 
                                                               'booking_status'=>request()->statusID,
                                                               'hold_date'=>$holdDate
                                                            ]); 
                        $userName = sHelper::getFullName(Auth::user());
                       
                        if($response){
                            if(request()->statusID == 2){
                                $holdDate = \Carbon\Carbon::parse($holdDate)->format(config('app.date_format'));
                                $notificationInfo = ['name'=>'jitu ' , 'msg'=>"$userName have Hold the Plot till $holdDate , plot number is : $plotDetail->plot_number " , 'plotId'=>$plotDetail->id];
                            }
                            else{
                                $plotNumberStatusArr = NULL;
                                if(array_key_exists(request()->statusID , $plotNumberStatus)){
                                   $plotNumberStatusArr =  $plotNumberStatus[request()->statusID];
                                }
                                
                                $notificationInfo = ['name'=>'jitu ' , 'msg'=>"$userName have $plotNumberStatusArr the plot , plot number is : $plotDetail->plot_number " , 'plotId'=>$plotDetail->id];
                            }
                            event(new PlotsBookingEvent($notificationInfo));
                            return json_encode(['status'=>200 , "msg"=>"<div class='notice notice-success notice'><strong>Success </strong> Status change successfully  !!! </div>"]);
                        }else{
                                return json_encode(['status'=>100 , "msg"=>"<div class='notice notice-danger notice'><strong> Wrong </strong> Something went wrong please try again  !!! </div>"]);
                        }
                    }
    
                }else{
                    return json_encode(['status'=>100 , "msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  please select one status  !!! </div>"]);
                }
            }else{
                return json_encode(['status'=>100 , "msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Plot number is required !!! </div>"]);
            }
        }
    }


    /*Mark ad unread function */
    public function markNotification(){
       if(Auth::check()){
           $updateResponse = auth()->user()
                                ->unreadNotifications
                                ->markAsRead();
            return response()->noContent();
       }
    }
    /*End*/


    public function calculateCommission(){
        if(!empty(request()->brokerID)){
            $commision = 0;
            $user = User::find(request()->brokerID);
            if($user != NULL){  
               $commision =  sHelper::brokerCommision(request()->plotValue , $user->commission);
            }
            echo $commision;exit;
        }
    }


    public function invoice($paymentHistoryId){
       $data['title'] = "Invoice";
       $data['remainAmount'] = $accountNumber = 0;
       $data['blockDetail'] =  $data['societyDetail'] = $data['buyerDetail'] = $data['brokerDetail'] = NULL;
       $data['paymentHistory'] = PlotPaymentHistory::with(['plotPaymentHistory'])->find($paymentHistoryId);
       if($data['paymentHistory'] != NULL){
           $data['blockDetail']   = $data['paymentHistory']->plotPaymentHistory->plotBlock;
           $data['brokerDetail']  = $data['paymentHistory']->plotPaymentHistory->brokerDetail;
           $data['societyDetail'] = $data['paymentHistory']->plotPaymentHistory->plotSociety;
           $data['buyerDetail']   = $data['paymentHistory']->plotPaymentHistory->buyerDetails;
         
           //Account details
            $data['accountNumber'] = $data['buyerDetail']->f_name."".Str::substr($data['buyerDetail']->login_id , 0,3);
            //    echo "<pre>";
            // print_r($accountNumber);exit;
           // echo $accountNumber;exit;
           /*due amount*/
           $data['installmentNumber'] = 1;
           $totalPaidPaymentCollect = PlotPaymentHistory::where([['society_plots_number_id','=',$data['paymentHistory']->society_plots_number_id]])->get();
            //echo "<pre>";
            //print_r($totalPaidPaymentCollect);exit;
                if($totalPaidPaymentCollect->count() > 0){
                    $data['installmentNumber'] = $totalPaidPaymentCollect->count() + 1;
                    $totalPaidPayment = $totalPaidPaymentCollect->sum('paid_amount');
                    $data['remainAmount'] =  $data['paymentHistory']->plotPaymentHistory->plot_value - $totalPaidPayment;
                }
          
           //$data['remainAmount']  = 
       }
       return view('invoice')->with($data);
    }



    public function  printInvoice($plotNumberID){
        $data['remainAmount'] = 0;
        $data['plotDetail'] = SocietyPlotsNumber::with(['plotPaymentHistory','plotSociety','plotBlock'])->where([['id','=',$plotNumberID]])->first();
        if($data['plotDetail'] != NULL){
            $data['plotDetail']->plot_description = sHelper::returnPlotDescription($data['plotDetail']);
            $totalPaidPaymentAmount = $data['plotDetail']->plotPaymentHistory->sum('paid_amount');
            if(!empty($data['plotDetail']->plot_value)){
                $data['remainAmount'] = $data['plotDetail']->plot_value - $totalPaidPaymentAmount;
            }
            $data['buyerDetail'] = NULL;
            if($data['plotDetail']->buyer_id){
                $data['buyerDetail'] = User::find($data['plotDetail']->buyer_id);
                //echo "<pre>";
                //print_r($data['buyerDetail']);exit;
            }
        }
        return view('indra_nagar_invoice')->with($data);
    }
	
}
