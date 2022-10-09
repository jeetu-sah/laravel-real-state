<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\PlotPaymentHistory;
use App\SocietyPlotsNumber;
use App\Society;
use App\SpcietyRooms;
use App\User;

class Dashboard extends Controller
{

    public $userObj;
    public $plotNumberObj;

    public function __construct(){
        $this->userObj = new User;
        $this->plotNumberObj = new SocietyPlotsNumber;
    }

    public function page($page){
        $data['title'] = "lakhmanis - Admin | ".$page;
        $data['notifications'] = auth()->user()->unreadNotifications;
        /*return main owner list*/
         $data['mainOwners'] = $this->userObj->mainOwnerList();
        /*End*/
        if($page == "plots"){   
            $data['brokerOwners'] = $this->userObj->brokerList();
           // echo "<pre>";
            //print_r($data['brokerOwners']);exit;
        }
   

        if(! view()->exists("admin.pages.dashboard.$page")){
           return view('admin.404');
        }
        return view("admin.pages.dashboard.$page")->with($data);
    }
    
    

    public function latestPayment(){
        // echo "<pre>";
        // print_r(request()->all());exit;
        $skip = 0; $limit = 10;
        if(!empty(request()->input('start'))){
            $skip = request()->input('start');
        }
        if(!empty(request()->input('length'))){
            $limit = request()->input('length');
        }
        $columns = [0=>'plot_payment_histories.paid_amount_date',1=>'plot_payment_histories.paid_amount_date', 2=>'plot_payment_histories.paid_amount', 3=>'society_plots_numbers.plot_number', 4=>'block.title',5=>'society.name', 6=>'broker.f_name', 7=>'society_plots_numbers.buyer_name',  8=>'mainOwner.f_name'];
		$dir = request()->input('order.0.dir');
        if($dir == "asc"){ $dir = "ASC"; }
        else{ $dir = "DESC"; }
        $order = $columns[request()->input('order.0.column')];
        $paymentQuery = PlotPaymentHistory::orderBy($order , $dir);
                        if(!empty(request()->mainOwner)){
                            $paymentQuery->where([['plot_payment_histories.payment_holder_id','=',(int)request()->mainOwner]]); 
                        }
                        if(!empty(request()->startDate)){
                            $startDate = request()->startDate;
                            if(!empty(request()->startDate) AND !empty(request()->endDate)){
                                $endDate = request()->endDate;
                                $paymentQuery->where([['plot_payment_histories.paid_amount_date','>=',$startDate],['plot_payment_histories.paid_amount_date','<=',$endDate]]);
                            }else{
                                $paymentQuery->where([['plot_payment_histories.paid_amount_date','>=',$startDate]]);
                            }
                        }
                       
                        $paymentQuery->join('users as mainOwner',function($join){
                            $join->on('plot_payment_histories.payment_holder_id','=','mainOwner.id');
                        });
                        $paymentQuery->join('society_plots_numbers',function($join){
                            $join->on('plot_payment_histories.society_plots_number_id','=','society_plots_numbers.id');
                        });
                        $paymentQuery->join('users as broker',function($join){
                            $join->on('society_plots_numbers.broker_id','=','broker.id');
                        });
                        $paymentQuery->join('spciety_rooms as block',function($join){
                            $join->on('society_plots_numbers.society_plot_id','=','block.id');
                        });
                        $paymentQuery->join('societies as society',function($join){
                            $join->on('block.society_id','=','society.id');
                        });
        $paymentQuery->select('plot_payment_histories.paid_amount_date','plot_payment_histories.paid_amount','society_plots_numbers.*','broker.f_name','broker.l_name','block.title','society.name','mainOwner.f_name as mainOwnerName');        
        $totalRecord = $paymentQuery->count();
        $paymentHistory = $paymentQuery->skip($skip)->take($limit)->get();

        $paymentHistories = collect();
		if($paymentHistory->count() > 0){
            $i = 1;
			foreach($paymentHistory as $pHistory){
                $infoBtn =  "<a href='javascript::void()' data-societyid='".$pHistory->id."' data-toggle='tooltip' title='Add category' class='btn btn-danger remove_society' style='margin-right: 5px;'><i class='fas fa-trash'></i></a>&nbsp;";
                $paymentHistoryArr = [];
				$paymentHistoryArr['sn'] =  $i++;
				$paymentHistoryArr['payment_date'] = Carbon::parse($pHistory->paid_amount_date)->format(config('app.date_format')) ; ;
				$paymentHistoryArr['paid_amount'] = $pHistory->paid_amount ?? 0;
				$paymentHistoryArr['plot_number'] = $pHistory->plot_number ?? "N/A";;
				$paymentHistoryArr['block_name'] = $pHistory->title ?? "N/A";
				$paymentHistoryArr['society'] = '<a target="_blank" href="'.url('admin/society').'">'.$pHistory->name ?? 'N/A'.'</a>';
				$paymentHistoryArr['broker'] = $pHistory->f_name;
				$paymentHistoryArr['buyer'] = $pHistory->buyer_name;
				$paymentHistoryArr['main_owner'] = $pHistory->mainOwnerName;
			/* 	$paymentHistoryArr['action'] = $infoBtn; */
				$paymentHistories[] = $paymentHistoryArr;
			}
        }
        $json_data = array(
			"draw"            => intval(request()->input('draw')),  
			"recordsTotal"    => intval($totalRecord),  
			"recordsFiltered" => intval($totalRecord), 
			"data"            => $paymentHistories   
		);
		return json_encode($json_data); exit;
		
    }
    

    public function plots(){
        //echo "<pre>";
        //print_r(request()->all());exit;

        $brokerOwners = $this->userObj->brokerList();
        $plotBookingStatuName = $this->plotNumberObj->plotBookingStatuName;
       
        $skip = 0; $limit = 10;
        if(!empty(request()->input('start'))){
            $skip = request()->input('start');
        }
        if(!empty(request()->input('length'))){
            $limit = request()->input('length');
        }
        
        $columns = [0=>'society_plots_numbers.plot_number',1=>'society_plots_numbers.plot_number',2=>'society_plots_numbers.society_plot_id', 3=>'society_plots_numbers.society_id', 4=>'society_plots_numbers.booking_date', 5=>'block.booking_status', 6=>'society_plots_numbers.broker_id', 7=>'society_plots_numbers.buyer_name'];
        
        $dir = request()->input('order.0.dir');
        if($dir == "asc"){ $dir = "ASC"; }
        else{ $dir = "DESC"; }

        $order = $columns[request()->input('order.0.column')];

        $plotNumberQuery = SocietyPlotsNumber::with(['plotBlock','plotSociety'])->orderBy($order , $dir);
                            if(!empty(request()->input('broker'))){
                                $plotNumberQuery->where([['broker_id','=',request()->input('broker')]]);
                            }
                            if(!empty(request()->input('plotNumber'))){
                                $plotNumberQuery->where([['plot_number','=',request()->input('plotNumber')]]);
                            }
        $totalRecord = $plotNumberQuery->count();
        $plotNumbers = $plotNumberQuery->skip($skip)->take($limit)->get();

        $paymentHistories = collect();
		if($plotNumbers->count() > 0){
            $i = 1;
			foreach($plotNumbers as $plotNumber){
                /*find broker name*/
                $brokerName = "N/A";
                if(!empty($plotNumber->broker_id)){
                    $brokerObject = $brokerOwners->where('id',$plotNumber->broker_id)->first();
                    if($brokerObject != NULL){
                        $brokerName = $brokerObject->f_name;
                    }
                }
                /*End*/
                /* */
                $bookingStatus = "N/A";
                if(array_key_exists($plotNumber->booking_status ,$plotBookingStatuName)){
                   $bookingStatus = $plotBookingStatuName[$plotNumber->booking_status];
                }
                /*End*/
                $infoBtn =  "<a href='javascript::void()' data-societyid='".$plotNumber->id."' data-toggle='tooltip' title='Add category' class='btn btn-danger remove_society' style='margin-right: 5px;'><i class='fas fa-trash'></i></a>&nbsp;";
                $plotNumberArr = [];
				$plotNumberArr['sn'] =  $i++;
				$plotNumberArr['plot_number'] = $plotNumber->plot_number ?? "N/A";
				$plotNumberArr['block'] = $plotNumber->plotBlock->title ?? "N/A";
				$plotNumberArr['society'] =  $plotNumber->plotSociety->name ?? "N/A";
				$plotNumberArr['booking_date'] =  Carbon::parse($plotNumber->booking_date)->format(config('app.date_format')) ; ;
				$plotNumberArr['status'] = $bookingStatus;
				$plotNumberArr['broker'] = $brokerName ?? "N/A";
				$plotNumberArr['buyer'] = $plotNumber->buyer_name ?? "N/A";;
				$paymentHistories[] = $plotNumberArr;
			}
        }
        $json_data = array(
			"draw"            => intval(request()->input('draw')),  
			"recordsTotal"    => intval($totalRecord),  
			"recordsFiltered" => intval($totalRecord), 
			"data"            => $paymentHistories   
		);
		return json_encode($json_data); exit;
		
	}

	

}
