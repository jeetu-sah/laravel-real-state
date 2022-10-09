<?php
namespace App\Traits;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\User , App\SpcietyRooms, App\Society;
use App\SocietyPlotsNumber , App\PlotPaymentHistory;
use sHelper;

trait PlotsTraits {

    /**
     * Does very basic image validity checking and stores it. Redirects back if somethings wrong.
     * @Notice: This is not an alternative to the model validation for this field.
     *
     * @param Request $request
     * @return $this|false|string
     */

     public function plotBuyDetail($plotID) {
        $dataCollect = [];
        $userObj = new User;
        $plotNumberObj = new SocietyPlotsNumber;
        /*plot Details with buyer name */
        /*Society plots number*/
        $plotsDetail = SocietyPlotsNumber::with(['plotBlock','plotSociety','plotNumber','plotPaymentHistory'])->find($plotID);
        /*End*/
        /*Plot Booking status */
        $plotsDetail->plotsBookingStatusArr  = $plotNumberObj->plotBookingStatuName;
        /*End*/
        $plotsDetail->brokerList =  $userObj->brokerList();
        $plotsDetail->mainOwners  = $userObj->mainOwnerList();
        $plotsDetail->buyer  = $userObj->buyer();
        return $plotsDetail;
        //return  DB::table('notifications')->where([['notifiable_id','=',Auth::user()->id]])->orderBy('created_at','DESC')->get();
    }

    public function returnPlotInvoiceResponse($plotID){
        $plotDetail = SocietyPlotsNumber::where([['id','=',$plotID]])->first();
        return $plotDetail;
    }

    public function plotsNumber($societyBlockID){
      $blockDetails = SpcietyRooms::where([['id','=',$societyBlockID]])->first();
      if($blockDetails != NULL){
           $blockDetails->plotsBookingStatusArr = $this->plotNumberObj->plotBookingStatuName;
          $blockDetails->societyDetails =  Society::with(['society_map'])->find($blockDetails->society_id);
      }
      return $blockDetails;
    }

    public function plotDetails($plotNumberID){
        /*find plots details with broker name*/
        $query = SocietyPlotsNumber::where([['society_plots_numbers.id','=',$plotNumberID]]);
                $query->leftjoin('users as u',function($join){
                    $join->on('society_plots_numbers.broker_id','=','u.id');
                });
        $plotsDetails =  $query->select('society_plots_numbers.*','u.f_name','u.l_name')->first();
        if($plotsDetails != NULL){
            /*Main Owner List*/
            $plotsDetails->mainOwners = $this->userObjs->mainOwnerList();
            /*End*/
            /*buyer details*/
            $plotsDetails->buyers = $this->userObjs->buyer();
            /*end*/
            /*Broker names */
            $plotsDetails->brokers = $this->userObjs->brokerList();
            /*End*/
            if(array_key_exists($plotsDetails->booking_status ,$this->plotNumberObj->plotBookingStatuName)){
                $plotsDetails->plotsBookingStatusArr = $this->plotNumberObj->plotBookingStatuName;
                $plotsDetails->bookingStatus =  $this->plotNumberObj->plotBookingStatuName[$plotsDetails->booking_status];
            }
            $plotsDetails->paymentMethodArr = $this->paymentHistoryObj->paymentMethodStatus;
            /*buyer detail*/
            if(!empty($plotsDetails->buyer_id)){
                $plotsDetails->buyer = User::find($plotsDetails->buyer_id);
            }
            /*End*/
            /*total payment amount*/
            /*Find Payment history of this plots */
            /*End*/
            $totalPaidAmount = 0;
            $paymentHistory = PlotPaymentHistory::where([['society_plots_number_id','=',$plotNumberID]])->get();
            $plotsDetails->remainAmount =  $plotsDetails->plot_value;
            if($paymentHistory->count() > 0){
                $plotsDetails->totalPaidAmount =  $totalPaidAmount = $paymentHistory->sum('paid_amount');
              
                if($totalPaidAmount){
                    $plotsDetails->remainAmount = $plotsDetails->plot_value - $totalPaidAmount;
                }   
            }
            $plotsDetails->paymentHistory = $paymentHistory;
            /*End*/
            /*calculate broker commission*/
            $brokerCommission = 0;
            if(!empty($plotsDetails->broker_id)){
                $broker = User::find($plotsDetails->broker_id);
                $plotsDetails->brokerCommission = sHelper::brokerCommision($plotsDetails->plot_value , $broker->commission);
            }
            /*end*/
            $holdDate = NULL;
            if($plotsDetails != NULL){
                $plotsDetails->societyBlock = SpcietyRooms::with(['societyDetail'])->find($plotsDetails->society_plot_id);
                if(array_key_exists($plotsDetails->booking_status ,$this->plotNumberObj->plotBookingStatuName)){
                    if($plotsDetails->booking_status == 2){
                        $plotsDetails->holdDate = \Carbon\Carbon::parse($plotsDetails->hold_date)->format(config('app.date_format')) ;
                    }
                    $plotsDetails->bookingStatus = $this->plotNumberObj->plotBookingStatuName[$plotsDetails->booking_status];
                }
            }
        }
        return $plotsDetails;
    }


}
