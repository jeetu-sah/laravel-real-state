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

class PlotPaymentController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($plotid)
    {
        $data['title'] = "Add Payment | Lakhmanis";
         //notification
        $data['notifications'] = auth()->user()->unreadNotifications;
        $usrObj = new User;
        $data['mainOwners'] = $usrObj->mainOwnerList();
        $plotNumberObj = new SocietyPlotsNumber;
        $data['plotsBookingStatusArr'] = $plotNumberObj->plotBookingStatuName;
        $paymentHistoryObj = new PlotPaymentHistory;
        $data['paymentMethodArr'] = $paymentHistoryObj->paymentMethodStatus;
        $data['holdDate'] = NULL;
        $SocietyPlotsNumberObj = new SocietyPlotsNumber;
        $query = SocietyPlotsNumber::where([['society_plots_numbers.id','=',$plotid]]);
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
            $data['totalPaidAmount'] = PlotPaymentHistory::where([['society_plots_number_id','=',$plotid]])->sum('paid_amount');
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
            $data['installmentNumber'] = PlotPaymentHistory::where([['installment_number','!=',NULL],
                                                ['society_plots_number_id','=',$data['plotsDetails']->id]])
                                            ->count() + 1;
        }
        return view("admin.pages.plot.payment.add")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
