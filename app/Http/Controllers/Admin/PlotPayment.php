<?php

namespace App\Http\Controllers\Admin;;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PlotPaymentHistory;

class PlotPayment extends Controller
{
    

    public function editPlotPaymentHistory(){
        $installmentNumber = $emi_status = NULL;
        $validatedData = request()->validate([
            'paymentHistoryID' =>'required',
            'total_plot_amount' =>'required',
            'payment_amount'=>'required',
			'payment_type'=>'required',
			'remain_payment_amount'=>'required',
			'payment_date'=>'required',
			'bank_details'=>'required',
        ]);
        $plotPaymentDetail =  PlotPaymentHistory::where([['id','=',request()->paymentHistoryID]])->first();
        if($plotPaymentDetail != NULL){
            $screen_shot_file_url = $plotPaymentDetail->payment_file;
            $reference_number = $plotPaymentDetail->reference_number;
          
            if(!empty(request()->payment_type)){
                if(request()->payment_type != 2){
                    if(!empty(request()->reference_number)){
                        $reference_number = request()->reference_number;
                    }
                }
                if(request()->has('file')){
                    $uploadScreenShot = $this->paymentScreenShots(request());
                    $screen_shot_file_url =  $uploadScreenShot[1];
                }

                if(!empty(request()->installment_status)){
                    $installmentNumber = request()->installment_number;
                    $emi_status = request()->installment_status;
                }
               
                $plotNumberSave = PlotPaymentHistory::where([['id','=',request()->paymentHistoryID]])
                                                            ->update(['payment_method'=>(int)request()->payment_type,
                                                                'reference_number'=>$reference_number,
                                                                'paid_amount'=>request()->payment_amount,
                                                                'remain_amount'=>request()->remain_payment_amount,
                                                                'paid_amount_date'=>request()->payment_date,
                                                                'emai_status'=>$emi_status,
                                                                'payment_file'=>$screen_shot_file_url,
                                                                'installment_number'=>$installmentNumber,
                                                                'bank_detail'=>request()->bank_details,
                                                                ]);
                 if($plotNumberSave){
                    return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong> Payment Successfully added  !!! </div>"]); 
        
                }else{
                    return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>Something went wrong , please try again   !!! </div>"]); 
                }
            }else{
                return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>Please Select Payment method type  !!! </div>"]); 
            }
        }
    }

    public function addPlotPaymentHistory(){
        $reference_number = $screen_shot_file_url = $installmentNumber = $emi_status = NULL;
        $validatedData = request()->validate([
            'plotNumberID' =>'required',
            'total_plot_amount' =>'required',
            'payment_amount'=>'required',
			'payment_type'=>'required',
			'remain_payment_amount'=>'required',
			'payment_date'=>'required',
        ]);
        $plotPaymentDetail =  PlotPaymentHistory::where([['society_plots_number_id','=',request()->plotNumberID]])->first();
        if($plotPaymentDetail != NULL){
            $paymentHolderId = $plotPaymentDetail->payment_holder_id;
        }
     
        if(request()->has('file')){
            $uploadScreenShot = $this->paymentScreenShots(request());
            $screen_shot_file_url =  $uploadScreenShot[1];
        }
        if(!empty(request()->reference_number)){
            $reference_number = request()->reference_number;
        }
        
        if(!empty(request()->installment_status)){
            $installmentNumber = request()->installment_number;
            $emi_status = 1;
        }
        
            $plotNumberSave = PlotPaymentHistory::create(['society_plots_number_id'=>request()->plotNumberID,
                                                            'payment_holder_id'=>$paymentHolderId,
                                                            'buyer_name'=>request()->buyer_name,
                                                            'payment_method'=>(int)request()->payment_type,
                                                            'reference_number'=>$reference_number,
                                                            'branch_name'=>request()->branch_name,
                                                            'paid_amount'=>request()->payment_amount,
                                                            'remain_amount'=>request()->remain_payment_amount,
                                                            'paid_amount_date'=>request()->payment_date,
                                                            'payment_file'=>$screen_shot_file_url,
                                                            'emai_status'=>$emi_status,
                                                            'installment_number'=>$installmentNumber,
                                                            'bank_detail'=>request()->bank_details,
                                                            ]);
             if($plotNumberSave){
                return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong> Payment Successfully added  !!! </div>"]); 

            }else{
                return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>Something went wrong , please try again   !!! </div>"]); 
            }
            
    
    }
    


    public function removePayemntHistory($paymentHistoryID){
        if(!empty($paymentHistoryID)){
            $deleteResponse = PlotPaymentHistory::find($paymentHistoryID);
         
            if($deleteResponse){
                  $deleteResponse->deleted_at = now();
                  $deleteResponse->save();
                  return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong> Payment delete  Successfully !!! </div>"]); 
            }else{
                  return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>Something went wrong , please try again   !!! </div>"]);
            }
        }else{
            return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>Something went wrong , please try again   !!! </div>"]);
        }
    }
    
}
