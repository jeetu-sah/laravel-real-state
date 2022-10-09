<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Society;
use App\SpcietyRooms;
use App\SocietyPlotsNumber;
use App\PlotPaymentHistory;
use sHelper;
use App\User;
use App\Traits\PlotsTraits;

class Rooms extends Controller
{
    use PlotsTraits;

    public $userObjs;
    public $plotNumberObj;
    public $paymentHistoryObj;
    public function __construct(){
        $this->userObjs = new User;
        $this->plotNumberObj = new SocietyPlotsNumber;
        $this->paymentHistoryObj = new PlotPaymentHistory;
    }

    public function index($p1){
       	if(empty($p1)){ return redirect()->back(); }
        $data['title'] = "lakhmanis | Rooms";
        $data['societyDetails'] =  Society::with(['society_map'])->find($p1);
        $data['notifications'] = auth()->user()->unreadNotifications;
        /*show roooms list*/
        if($data['societyDetails'] != NULL){
            $data['rooms'] = SpcietyRooms::where([['society_id','=',$data['societyDetails']->id]])->get();
        }
        /*End*/
        if(! view()->exists('admin.pages.plots')){
           return view('admin.404');
        }
        return view('admin.pages.plots')->with($data);
    }


    public function pages($page , $p1){
        $data['title'] = "lakhmanis | Rooms";
        $data['notifications'] = auth()->user()->unreadNotifications;
        if($page == "add_plots"){
            if(empty($p1)){ return redirect()->back(); }
            $data['priority'] = SpcietyRooms::max('id') + 1;
            $data['societyDetails'] =  Society::with(['society_map'])->find($p1);
        }
        /*Edit plots page load script start*/
        if($page == "edit-plots"){
            if(empty($p1)){ return redirect()->back(); }
            $data['plotDetail'] = SpcietyRooms::find($p1);
            if($data['plotDetail'] != NULL){
                $data['societyDetails'] =  Society::with(['society_map'])->find($data['plotDetail']->society_id);
            }
        }
        /*End*/

        if($page == "roomsList"){
            if(empty($p1)){ return redirect()->back(); }
            /*rooms details */
            $data['roomsDetails'] = SpcietyRooms::where([['id','=',$p1]])->first();
            if($data['roomsDetails'] != NULL){
                  $data['societyDetails'] =  Society::with(['society_map'])->find($data['roomsDetails']->society_id);
            }
        }

       
        if($page == "editPlotsNumber"){
            if(empty($p1)){ return redirect()->back(); }
            $data['plotDetail'] = $this->plotBuyDetail($p1);
            // echo "<pre>";
            // print_r($data['plotDetail']);exit;
            
            /*Find Broker*/
            $data['brokerCommission'] = 0;
            if(!empty($data['plotDetail']->broker_id)){
                $broker = User::find($data['plotDetail']->broker_id);
                $data['brokerCommission'] = sHelper::brokerCommision($data['plotDetail']->plot_value , $broker->commission);
            }
            /*End*/
            $data['bookingDate'] = NULL;
            if(!empty($data['plotDetail']->booking_date)){
                 $data['bookingDate'] = \Carbon\Carbon::parse($data['plotDetail']->booking_date)->format(config('app.date_format_database'));
            } 
            /*Plot Amount and remain and paid amount*/
            $data['totalPaidAmount'] = 0;
            $data['remainAmount'] =  $data['plotDetail']->plot_value;
            $data['PlotPaymentHistory'] = $data['plotDetail']->plotPaymentHistory;
            if($data['PlotPaymentHistory']->count() > 0){
                $data['totalPaidAmount'] =  $data['PlotPaymentHistory']->sum('paid_amount');
                if($data['totalPaidAmount']){
                    $data['remainAmount'] = $data['plotDetail']->plot_value - $data['totalPaidAmount'];
                }   
            }
            /*End*/
          
        }

        /*add payemnt details */
        if($page == "addPlotPaymentDetail" || $page == "editPlotPaymentDetail"){
            $usrObj = new User;
            $data['mainOwners'] = $usrObj->mainOwnerList();
            $plotNumberObj = new SocietyPlotsNumber;
            $data['plotsBookingStatusArr'] = $plotNumberObj->plotBookingStatuName;
            $paymentHistoryObj = new PlotPaymentHistory;
            $data['paymentMethodArr'] = $paymentHistoryObj->paymentMethodStatus;
            $data['holdDate'] = NULL;
            $SocietyPlotsNumberObj = new SocietyPlotsNumber;
            if($page == "editPlotPaymentDetail"){
                $data['paymentHistory'] = PlotPaymentHistory::where([['id','=',$p1]])->first();
                if($data['paymentHistory'] != NULL){
                    $p1 = $data['paymentHistory']->society_plots_number_id;
                    $data['paymentDate'] = \Carbon\Carbon::parse($data['paymentHistory']->paid_amount_date)->format(config('app.date_format_database')) ;
               
                }
            }
            $query = SocietyPlotsNumber::where([['society_plots_numbers.id','=',$p1]]);
                    $query->join('users as u',function($join){
                        $join->on('society_plots_numbers.broker_id','=','u.id');
                    });
            $data['plotsDetails'] =  $query->select('society_plots_numbers.*','u.f_name','u.l_name')->first();
                
            if($data['plotsDetails'] != NULL){
                $data['societyDetails'] = Society::find($data['plotsDetails']->society_id);
                $data['societyBlock'] = SpcietyRooms::find($data['plotsDetails']->society_plot_id);
                if(array_key_exists($data['plotsDetails']->booking_status , $SocietyPlotsNumberObj->plotBookingStatuName)){
                    if($data['plotsDetails']->booking_status == 2){
                        $data['holdDate'] = \Carbon\Carbon::parse($data['plotsDetails']->hold_date)->format(config('app.date_format')) ;
                    }
                    $data['bookingStatus'] = $SocietyPlotsNumberObj->plotBookingStatuName[$data['plotsDetails']->booking_status];
                }
                /*End*/
                $data['totalPaidAmount'] = 0;
                $data['remainAmount'] =  $data['plotsDetails']->plot_value;
                $data['totalPaidAmount'] = PlotPaymentHistory::where([['society_plots_number_id','=',$p1]])->sum('paid_amount');
                if($data['totalPaidAmount']){
                    $data['remainAmount'] = $data['plotsDetails']->plot_value - $data['totalPaidAmount'];
                }   
                /*Broker Commission*/
                $data['brokerCommission'] = 0;
                if(!empty($data['plotsDetails']->broker_id)){
                    $broker = User::find($data['plotsDetails']->broker_id);
                    $data['brokerCommission'] = sHelper::brokerCommision($data['plotsDetails']->plot_value , $broker->commission);
                }
                //installment number
                $data['installmentNumber'] = PlotPaymentHistory::where([['emai_status','=',1],
                                                    ['society_plots_number_id','=',$data['plotsDetails']->id]])
                                                ->count() + 1;
            }
        }
        /*End */


        if($page == "paymentHistory"){
            if(empty($p1)){ return redirect()->back(); }
            $SocietyPlotsNumberObj = new SocietyPlotsNumber;
            $paymentHistoryObj = new PlotPaymentHistory;
            $data['paymentMethodArr'] = $paymentHistoryObj->paymentMethodStatus;
            $data['plotsDetails'] =  SocietyPlotsNumber::find($p1);
            if($data['plotsDetails'] != NULL){
                $data['societyDetails'] = Society::find($data['plotsDetails']->society_id);
                $data['societyBlock'] = SpcietyRooms::find($data['plotsDetails']->society_plot_id);
                if(array_key_exists($data['plotsDetails']->booking_status , $SocietyPlotsNumberObj->plotBookingStatuName)){
                    $data['bookingStatus'] = $SocietyPlotsNumberObj->plotBookingStatuName[$data['plotsDetails']->booking_status];
                }
            }
            /*Details management */
            $data['paymentHistory'] = PlotPaymentHistory::where([['society_plots_number_id','=', $data['plotsDetails']->id]])->orderBy('paid_amount_date','ASC')->get();
            /*End*/
        }
        if(!view()->exists("admin.pages.$page")){
           return view('admin.404');
        }
        return view("admin.pages.$page")->with($data);
    }



   

    /*plots remove script strat*/
    public function removePlot($plotID){
        if(!empty($plotID)){
            $societyPlot = SpcietyRooms::find($plotID);
            if($societyPlot != NULL){
                $societyPlot->delete();
                return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong> plots remove successfully  !!! </div>"]); 
            }else{
                return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
            }

        }else{
            return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
        }
    }
    /*End*/


    /*save rooms script start*/
    public function saveRooms(){
        $validatedData = request()->validate([
            'title' =>'required',
			'size_by_gaj'=>'required',
			'number_of_plots'=>'required',
			'priority'=>'required'
		]);
        $saveResponse = SpcietyRooms::create(['society_id'=>request()->society_id,
                                                'title'=>request()->title,
                                                'plot_size_by_gaj'=>request()->size_by_gaj,
                                                'number_of_plot'=>request()->number_of_plots
                                             ]);
        if($saveResponse){
			return redirect("admin/plots/plotsNumber/$saveResponse->id")->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Plot Create Successfully  !!! </div>"]); 
        }
        else{
            return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
        }
    }
    /*End*/


    /*Edit plots details script strat*/
    public function editPlot(){
        $validatedData = request()->validate([
            'title' =>'required',
			'size_by_gaj'=>'required',
			'number_of_plots'=>'required',
            'priority'=>'required',
            'society_id'=>'required',
            'plot_id'=>'required'
        ]);
        $plotDetail = SpcietyRooms::where([['id','=',request()->plot_id] , ['society_id','=',request()->society_id]])->first();
        if($plotDetail != NULL){
            $saveResponse = $plotDetail->update(['title'=>request()->title,
                                                    'plot_size_by_gaj'=>request()->size_by_gaj,
                                                    'number_of_plot'=>request()->number_of_plots
                                                 ]);
            if($saveResponse){
                $plotID = request()->plot_id;
                return redirect("admin/plots/plotsNumber/$plotID")->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Rooms Create Successfully  !!! </div>"]); 
            }
            else{
                return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
            }
        }else{
            return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
        }
       
    }
    /*End*/



    /*Rooms list scrirpt start*/
    public function roomsList(){
        $columns = [0=>'title' , 1=>'room_area', 2=>'plot_size_by_gaj', 3=>'plot_value'];
		$dir = request()->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
		else{ $dir = "DESC"; }
        $order = $columns[request()->input('order.0.column')];
        $societyID = request()->input('societyid');
        $societyRooms = SpcietyRooms::orderBy($order,$dir)->where([['society_id','=',$societyID]])->get();
		$roomsList = collect();
		if($societyRooms->count() > 0){
			$i = 1;
			foreach($societyRooms as $room){
				$change_credential = NULL;	
				$delete_btn =  "<a href='javascript::void()' data-plotid='".$room->id."' data-toggle='tooltip' title='Add category' class='btn btn-danger remove_plots' style='margin-right: 5px;'><i class='fas fa-trash'></i></a>&nbsp;";
				$edit_btn = '<a href="'.url("admin/plots/edit-plots/".$room->id).'" data-toggle="tooltip" title="Edit Record" class="btn btn-primary" style="margin-right: 5px;">
                    <i class="fas fa-edit"></i> 
				  </a>';
				$roomList = [];
				$roomList['sn'] = $room->id;
				//$roomList['title'] = '<a href="'.url("admin/plots/plotsNumber/$room->id").'" target="_blank">'.$room->title.'</a>';
				$roomList['title'] = '<a href="'.route('admin.plot.index',[$room->id]).'" target="_blank">'.$room->title.'</a>';
				$roomList['room_area'] = $room->room_area;
				$roomList['plot_size_by_gaj'] = $room->plot_size_by_gaj;
				$roomList['plot_value'] = $room->plot_value;
				$roomList['number_of_plot'] = $room->number_of_plot;
				$roomList['action'] = $delete_btn.' '.$edit_btn;
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
    /*End*/


    /*Save pplots numbers*/
    public function savePlotsNumber(){
      if(!empty(request()->roomID)){
            $societyRooms = SpcietyRooms::find(request()->roomID);
            if($societyRooms != NULL){
                if(count(request()->plotsDetailsArr) > 0){
                    foreach(request()->plotsDetailsArr as $plots){

                        if(!empty($plots['plotNumber'])){
                            $plotValue = $priority = 0;
                            if(!empty($plots['plotValue'])){
                                $plotValue = $plots['plotValue'];
                            }
                            if(!empty($plots['priority'])){
                                $priority = $plots['priority'];
                            }
                     
                            SocietyPlotsNumber::create(['society_id'=>$societyRooms->society_id, 
                                                        'society_plot_id'=>$societyRooms->id,
                                                        'plot_number'=>$plots['plotNumber'],
                                                        'plot_value'=>$plotValue,
                                                        'plot_size_in_gaj'=>$plots['plotSize'],
                                                        'plot_area'=>$plots['plot_area'],
                                                        'booking_status'=>$plots['plotsBookingStatus'], 
                                                        'priority'=>$priority 
                                                        ]);

                        }

                    }
                    return json_encode(["msg"=>"<div class='notice notice-success notice'><strong>Wrong </strong> Plots save successfully  !!! </div>", 'status'=>200]);

                }else{
                    return json_encode(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>", 'status'=>100]);
                }
            }else{
                return json_encode(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>", 'status'=>100]);
            }
      }else{
         return json_encode(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>",'status'=>100]);
      }
    }
    /*Ebd*/


    /*save single plots numbers*/
    public function saveNewplots(){
        $priority = $plot_value = 0;
        if(!empty(request()->roomID)){
            if(!empty(request()->plot_number)){
                    $societyRooms = SpcietyRooms::find(request()->roomID);
                    if($societyRooms != NULL){
                        if(!empty(request()->priority)){
                            $priority = request()->priority;
                        }
                        if(!empty(request()->plot_value)){
                            $plot_value = request()->plot_value;
                        }
                        $saveResponse = SocietyPlotsNumber::create(['society_id'=>$societyRooms->society_id, 
                                                             'society_plot_id'=>$societyRooms->id,
                                                             'plot_number'=>request()->plot_number,
                                                             'plot_value'=>$plot_value,
                                                             'plot_size_in_gaj'=>request()->plot_size,
                                                             'plot_area'=>request()->plot_area,
                                                             'booking_status'=>request()->booking_status,
                                                             'priority'=>$priority
                                                             ]);
                        if($saveResponse){
                            return json_encode(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong> Plots number save successfully  !!!.</div>",'status'=>200]);
                          
                        }else{
                            return json_encode(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Block not exists in our database !!!.</div>",'status'=>100]);
                        }
                        
                    }else{
                        return json_encode(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Block not exists in our database !!!.</div>",'status'=>100]);
                    }

            }else{
                return json_encode(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Plot Number is required !!!.</div>",'status'=>100]);
            }
        }else{
            return json_encode(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>",'status'=>100]);
        }
    }
    /*End*/

    /*Get Plots details script start*/
    public function getPlotsDetails(){
        if(!empty(request()->plotID)){
            $plotDetails = SocietyPlotsNumber::find(request()->plotID);
            if($plotDetails != NULL){
                return json_encode(['status'=>200 , 'r'=>$plotDetails]);
            }else{
                 return json_encode(['status'=>100 ]);
            }
        }else{
            return json_encode(['status'=>100]);
        }
    }
    /*End*/


    /*save single plots numbers*/
    public function editNewplots(){
        $priority = 0;
        if(!empty(request()->plotID)){
            if(!empty(request()->plot_number)){
                    $societyPlots = SocietyPlotsNumber::find(request()->plotID);
                    if($societyPlots != NULL){
                        if(!empty(request()->priority)){
                            $priority = request()->priority;
                        }
                        $saveResponse =$societyPlots->update(['plot_number'=>request()->plot_number,
                                                             'plot_value'=>request()->plot_value,
                                                             'plot_size_in_gaj'=>request()->plot_size,
                                                             'plot_area'=>request()->plot_area,
                                                             'booking_status'=>request()->booking_status,
                                                             'priority'=>$priority
                                                             ]);
                        if($saveResponse){
                              return json_encode(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong> Plots number save successfully  !!!.</div>",'status'=>200]);
                        }else{
                              return json_encode(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Block not exists in our database !!!.</div>",'status'=>100]);
                        }
                    }else{
                          return json_encode(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Block not exists in our database !!!.</div>",'status'=>100]);
                    }

            }else{
                  return json_encode(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Plot Number is required !!!.</div>",'status'=>100]);
            }
        }else{
              return json_encode(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>",'status'=>100]);
        }
    }
    /*End*/

    /*change the status of plots number only*/
    public function setBookingStatus(){
        if(!empty(request()->plotNumberID)){
            
        }else{
             echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit; 
        }
    }
    /*End*/




    /*save plots payment*/

    public function savePlotPayment(){
        $reference_number = $screen_shot_file_url = $bookingDate =  NULL;
        $down_payment_amount = $number_of_emi  = $payment_of_emi = 0;
        $validatedData = request()->validate([
            'plotNumberID' =>'required',
			'booking_status' =>'required',
            'payment_holder_name'=>'required',
            'buyer'=>'required',
            'broker'=>'required',
			'payment_type'=>'required',
			'total_plot_amount'=>'required',
			'payment_amount'=>'required',
			'remain_payment_amount'=>'required',
			'payment_date'=>'required',
        ]);
        if(!empty(request()->booking_date)){
            $bookingDate = \Carbon\Carbon::parse(request()->booking_date)->format(config('app.date_format_database'));
        }
        if(!empty(request()->down_payment_amount)){
            $down_payment_amount  = request()->down_payment_amount;
        }
        if(!empty(request()->number_of_emi)){
           $number_of_emi  = request()->number_of_emi;
        }
        if(!empty(request()->emi_payment_amount)){
            $payment_of_emi = request()->emi_payment_amount;
        }
        $savePlotNumberStatus = SocietyPlotsNumber::where([['id','=',request()->plotNumberID]])
                                                    ->update(['broker_id'=>request()->broker,
                                                              'buyer_id'=>request()->buyer,
                                                              'broker_commission'=>request()->broker_commision,
                                                              'buyer_name'=>request()->buyer_name,
                                                              'buyer_mobile_number'=>request()->buyer_mobile_number,
                                                              'plot_value'=>request()->total_plot_amount,
                                                              'booking_status'=>request()->booking_status,
                                                              'booking_date'=>$bookingDate,
                                                              'down_payment_amount'=>$down_payment_amount,
                                                              'number_of_emi'=>$number_of_emi,
                                                              'payment_of_emi'=>$payment_of_emi,
                                                            ]);
              
        if($savePlotNumberStatus){
            if(request()->has('file')){
                $uploadScreenShot = $this->paymentScreenShots(request());
                $screen_shot_file_url =  $uploadScreenShot[1];
            }
            if(!empty(request()->reference_number)){
                $reference_number = request()->reference_number;
            }
            $brokerCommission = 0;
            if(!empty(request()->broker_commision)){
                $brokerCommission = request()->broker_commision;
            }
            $plotNumberSave = PlotPaymentHistory::create(['society_plots_number_id'=>request()->plotNumberID,
                                                            'payment_holder_id'=>request()->payment_holder_name,
                                                            'buyer_name'=>request()->buyer_name,
                                                            'buyer_mobile_number'=>request()->buyer_mobile_number,
                                                            'payment_method'=>(int)request()->payment_type,
                                                            'reference_number'=>$reference_number,
                                                            'branch_name'=>request()->branch_name,
                                                            'paid_amount'=>request()->payment_amount,
                                                            'remain_amount'=>request()->remain_payment_amount,
                                                            'paid_amount_date'=>request()->payment_date,
                                                            'payment_file'=>$screen_shot_file_url,
                                                            'bank_detail'=>request()->bank_details,
                                                            ]);
            if($plotNumberSave){
                return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong> Payment Successfully added  !!! </div>"]); 

            }else{
                return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>Something went wrong , please try again   !!! </div>"]); 
            }
        }else{
            return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>Something went wrong , please try again   !!! </div>"]); 
        }
    }
    /*End*/

    /*this funciton is used to set plot number priority*/
    public function setPriority(){
        if(!empty(request()->priority)){
            if(!empty(request()->plotNumberID)){
                $saveResponse = SocietyPlotsNumber::where([['id','=',request()->plotNumberID]])->update(['priority'=>request()->priority]);
            }else{
                echo "Something went wrong , please try again   !!! ";exit;
            }
        }else{
            echo "Priority is required   !!!";exit;
        }
    }
    /*End*/
    /*this funciton is used to set plot number EMI Status*/
    public function setEmiStatus(){
        $emiStatus = NULL;
        if(!empty(request()->plotEmiStatus)){
            $emiStatus = 1;
        }
        if(!empty(request()->plotNumber)){
            $saveResponse = SocietyPlotsNumber::where([['id','=',request()->plotNumber]])->update(['emi_status'=>$emiStatus]);
        }else{
            echo "plot Number is required   !!!";exit;
        }
    }
    /*End*/


    public function editPlotPaymentDetail(){
        $bookingDate = NULL;
        $down_payment_amount = $number_of_emi  = $payment_of_emi = 0;
         $validatedData = request()->validate([
            'plotNumberID' =>'required',
			'booking_status' =>'required',
			'broker'=>'required',
            'buyer'=>'required',
			'broker_commision'=>'required',
	    ]);
        /*Edit plot details */
        if(!empty(request()->booking_date)){
            $bookingDate = \Carbon\Carbon::parse(request()->booking_date)->format(config('app.date_format_database'));
        }
        if(!empty(request()->down_payment_amount)){
            $down_payment_amount  = request()->down_payment_amount;
        }
        if(!empty(request()->number_of_emi)){
           $number_of_emi  = request()->number_of_emi;
        }
        if(!empty(request()->emi_payment_amount)){
            $payment_of_emi = request()->emi_payment_amount;
        }
        $editResponse = SocietyPlotsNumber::where([['id','=',request()->plotNumberID]])
                                            ->update(['booking_status'=>request()->booking_status, 
                                             'buyer_id'=>request()->buyer,
                                             'broker_id'=>request()->broker,
                                             'broker_commission'=>request()->broker_commision,
                                             'booking_date'=>$bookingDate,
                                            'down_payment_amount'=>$down_payment_amount,
                                            'number_of_emi'=>$number_of_emi,
                                            'payment_of_emi'=>$payment_of_emi,
                                             ]);
        if($editResponse != NULL){
             return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'>
                <strong>Success </strong>Record Edit Successfully  !!! </div>"]); 
        }else{
             return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>Something went wrong , please try again   !!! </div>"]); 
        }
        /*End*/
    }

}
