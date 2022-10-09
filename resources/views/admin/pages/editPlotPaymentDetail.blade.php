@extends('admin.component.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
@if($plotsDetails != NULL)
<!-- Content Header (Page header) -->
<div class="content-header  navbar-white">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6  float-sm-right">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Dashboard</li>
              <li class="breadcrumb-item active">{{  $societyDetails->name ?? "N/A" }}</li>
              <li class="breadcrumb-item active">{{  $societyBlock->title ?? "N/A" }}</li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content header_margin">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-body">
                  <h6 class="card-title"><strong>Plot Details Details</strong></h6>
                  <div class="col-lg-12" style="margin-top:50px;">
                       @include('admin.pages.component.plotTableDetails')
                    </div>
                  <h6 class="card-text"></h6>
                  
                  <a href='{{ url("admin/plots/plotsNumber/$plotsDetails->society_plot_id") }}' class="btn btn-primary">Back</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="content header_margin">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <a href='{{ url("admin/plots/addPlotPaymentDetail/$plotsDetails->id") }}' data-toggle="tooltip" title="Add Payment Detail" class="btn btn-success float-right" style="margin-right:5px;">
            <i class="fas fa-plus"></i> 
            Add Payment Detail
            </a>
            <a href='{{ url("admin/plots/plotDetail/$plotsDetails->id") }}' data-toggle="tooltip" title="Payment History" class="btn btn-primary float-right" style="margin-right:5px;">
            <i class="fas fa-list"></i> 
            Payment History
            </a>
         </div>
      </div>
   </div>
</div>
<!-- Main content -->
<div class="content header_margin">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="card card-primary card-outline">
               <div class="col-sm-12">
                <div class="card-header">
                     <h5 class="m-0">Edit Plots Payment Details</h5>
                  </div>
                  <div class="card-body">
                     @if(Session::has('msg'))
                     {!!  Session::get("msg") !!}
                     @endif
                     @if ($errors->any())
                     @foreach ($errors->all() as $error)
                     <div class="notice notice-danger notice">
                        {{  $error }}
                     </div>
                     @endforeach
                     @endif
                    <form method="POST" action="{{ route('admin.plots.editPlotPaymentHistory') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="paymentHistoryID" id="paymentHistoryID" value="{{ $paymentHistory->id ?? 0 }}" readonly="readonly" />
                        <div>
                           <div class="colo-sm-12">
                               @if(($plotsDetails->emi_status == 1))
                               <div class="row">     
                                 <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="checkbox" 
                                                name="installment_status" 
                                                id="installment_status" 
                                                value="1" 
                                                @if($paymentHistory->emai_status == 1){{"checked"}} @endif
                                                />
                                        <label>Installment Payment  </label>
                                    </div>
                                 </div>
                              </div>
                              <div class="row" 
                                    style="display: @if($paymentHistory->emai_status != 1){{"none"}} @endif;" 
                                    id="installmentNUmberDiv">     
                                 <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Installment Number <span class="text-danger">*</span> </label>
                                         <input type="text" 
                                                class="form-control" 
                                                name="installment_number" 
                                                id="installment_number" 
                                                value="{{$paymentHistory->installment_number}}" />
                                    </div>
                                 </div>
                              </div>
                              @endif
                              <div class="row">     
                                 <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Select Payment Holder Name <span class="text-danger">*</span> </label>
                                        <div class="input-group">
                                            <select class="form-control payment_holder_name" name="payment_holder_name">
                                            @foreach($mainOwners as $owner)
                                              <option value="{{ $owner->id }}">{{ $owner->f_name }} </option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Select Payment Method<span class="text-danger">*</span></label>
                                       <div class="input-group">
                                          <select class="form-control payment_type" name="payment_type" id="payment_type">
                                             <option value="0">Select Payment Method </option>
                                             <option value="1" {{ ($paymentHistory->payment_method == 1) ? "selected" : " " }}> Cheque </option>
                                             <option value="2" {{ ($paymentHistory->payment_method == 2) ? "selected" : " " }}> Cash </option>
                                             <option value="3" {{ ($paymentHistory->payment_method == 3) ? "selected" : " " }}> Net Banking </option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label> Plot Value <span class="text-danger">*</span> </label>
                                       <div class="input-group">
                                          <input type="number" class="form-control" placeholder="Total Plot Amount" name="total_plot_amount" id="total_plot_amount" value="{{ $plotsDetails->plot_value ?? 0 }}" readonly="readonly" required="required" />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row" style="display:<?php if($paymentHistory->payment_method != 2) echo ""; else echo "none"; ?>;" id="referenceNumberDiv">
                                 <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Enter the Check/ Net Banking Reference Number </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder=" Check/ Net Banking Reference Number" name="reference_number" id="reference_number" value="{{ $paymentHistory->reference_number }}" />
                                        </div>
                                    </div>
                                 </div>
                            </div>
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Payment Amount <span class="text-danger">*</span> </label>
                                       <div class="input-group">
                                          <input type="number" class="form-control" placeholder="Payment Amount" name="payment_amount" value="{{ $paymentHistory->paid_amount ?? 0 }}" />
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Remain Payment Amount </label>
                                       <div class="input-group">
                                           <input type="number" class="form-control" placeholder="Remain Payment Amount" name="remain_payment_amount" value="{{ $paymentHistory->remain_amount ?? 0 }}"  />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Select Date  <span class="text-danger">*</span></label>
                                       <div class="input-group">
                                          <input type="date" class="form-control" placeholder="Select date" name="payment_date" value="{{$paymentDate}}" />
                                       </div>
                                    </div>
                                 </div>


                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Choose File Cheque / Payment Screenshots </label>
                                       @if(!empty($paymentHistory->payment_file))
                                       <a target="_blank" href="{{$paymentHistory->payment_file}}">Click to view</a>
                                       @endif
                                       
                                       <div class="input-group">
                                          <input type="file" class="form-control" name="file" />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label>Comments </label>
                                 <textarea name="bank_details" id="bank_details" class="form-control" placeholder="Comments " rows="5">{{$paymentHistory->bank_detail}}</textarea>
                              </div>
                              <div class="form-group">
                                 <div class="input-group">
                                    <button type="submit" name="save_category" class="btn btn-success">Save </button>
                                 </div>
                              </div>
                           </div>
                           <hr />
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@else
<div class="content-header  navbar-white">
  <h2 class="text-center" style="padding:100px;">Something , went wrong please try again !!!</h2>
@endif 
@stop
@section('script')
 @parent
<script>
$(document).ready(function(e) {
   $(document).on('change','#payment_type',function(e){
	  var paymentType = $(this).val();
	   if(paymentType == 1 || paymentType == 3){
		  $("#referenceNumberDiv").show();
	   }else{
	       $("#referenceNumberDiv").hide();
		}
   });
   $(document).on('change','#installment_status',function(){
      if($(this).is(':checked')){
         $("#installmentNUmberDiv").show();
      }else{
          $("#installmentNUmberDiv").hide();
      }
   })
});
</script>
@endsection