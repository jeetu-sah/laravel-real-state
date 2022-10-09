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


class PlotController extends Controller
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
    public function index($blockid)
    {
        $data['title'] = "Plots | Lakhmanis";
        //notification
        $data['notifications'] = auth()->user()->unreadNotifications;
        $data['plotDetails'] = $this->plotsNumber($blockid);
        // echo "<pre>";
        // print_r($data['plotDetails']);exit;
        $data['plotsBookingStatusArr'] = $data['plotDetails']->plotsBookingStatusArr;
        /*if plots was added at once time then open details page and edit */
        $data['plotsNumberResponse'] = SocietyPlotsNumber::where([['society_plot_id','=',$blockid]])->orderBy('id','DESC')->get();
        /*End*/
        return view("admin.pages.plot.plot-number")->with($data);
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
    public function plotDetail($id)
    {
        $data['title'] = "Plot Detail | lakhmanis";
        $data['notifications'] = auth()->user()->unreadNotifications;
        $data['plotsDetails'] = $this->plotDetails($id);
        // echo "<pre>";
        // print_r($data['plotsDetails']);exit;
        return view("admin.pages.plot.plot-detail")->with($data);
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




     /*block plots  list*/
    public function plotList(){
        $limit = 10; $start = 0;
        if(!empty(request()->input('length'))){
            $limit = request()->input('length');
        }
        if(!empty(request()->input('length'))){
            $limit = request()->input('length');
        }
        if(!empty(request()->input('start'))){
            $start = request()->input('start');
        }
        $plotNumberObj = new SocietyPlotsNumber;
        $plotsBookingStatusArr = $plotNumberObj->plotBookingStatuName;
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
        $totalNumberOFPlots = $query->count();
        $plotsNumberResponse = $query->orderBy('priority','ASC')->skip($start)->take($limit)->get();
       
        if($plotsNumberResponse->count() > 0){
            $societyID = request()->societyID;
            $i = 1;
            foreach($plotsNumberResponse as $key=>$plotsNumber){
                /*action button*/
                $actionBtn =  '<a data-plotid="'.$plotsNumber->id.'" href="javascript::void()" data-toggle="tooltip" title="Edit Plot Detail" class="btn btn-warning float-right editPlotDetails" style="margin-right: 5px;">
                <i class="fas fa-edit"></i>
                </a>';

                $actionBtn .= '<a target="_blank" href="'.route('admin.plot.plot-detail',[$plotsNumber->id]).'" data-toggle="tooltip" title="Check Plot Booking Detail" class="btn btn-primary float-right" style="margin-right: 5px;"> <i class="fas fa-info"></i></a>';

                /*End*/
                /*Checked unchecked*/
                $bookingStatusOption = '<select class="form-control booking_status" name="booking_status" data-plotnumber="'.$plotsNumber->id.'">';
                        foreach($plotsBookingStatusArr as $key=>$plotsBookingStatus){
							$bookingStatusOption .= '<option value="'.$key.'"'. (($plotsNumber->booking_status == $key) ? "selected" : " ") .'>'.$plotsBookingStatus .'</option>';
						}                
						$bookingStatusOption .='</select>';
                /*End*/
                /*EMI Status */
                $emiStatusChecked = NULL;
                if($plotsNumber->emi_status == 1){
                     $emiStatusChecked = 'checked';
                }
                $emiStaus = '<input type="checkbox" class="emi_statys" data-plotid="'.$plotsNumber->id.'"  '.$emiStatusChecked.'/>';
                /*End*/
                $plot_arr = [];
				$plot_arr['sn'] = $i;
				$plot_arr['emi_status'] = $emiStaus;
				$plot_arr['plot_number'] = $plotsNumber->plot_number;
				$plot_arr['plot_value'] = $plotsNumber->plot_value;
				$plot_arr['booking_status'] = $bookingStatusOption;
				$plot_arr['plot_size'] = $plotsNumber->plot_size_in_gaj ?? 0;
				$plot_arr['plot_area'] = $plotsNumber->plot_area ?? 0;
				$plot_arr['priority'] = '<input data-plotnumber="'.$plotsNumber->id.'" type="text" class="form-control plot_priority" value="'.$plotsNumber->priority .'">';;
				$plot_arr['action'] = $actionBtn;
                $plotList[] = $plot_arr;
                $i++;
            }
        }
        $json_data = array( "draw" => intval(request()->input('draw')),  
                            "recordsTotal" => intval($totalNumberOFPlots),  
                            "recordsFiltered" => intval($totalNumberOFPlots), 
                            "data"=> $plotList   
                         );
        return json_encode($json_data); exit;
    }
    /*End*/
}
