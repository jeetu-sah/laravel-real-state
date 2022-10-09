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
              <li class="breadcrumb-item active">{{ $plotsDetails->plot_number ?? "N/A"}}</li>
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
                    <a href='{{ route('admin.plot.index',[$plotsDetails->society_plot_id])}}' 
                      class="btn btn-primary">Back</a>
                  
                   @if(!empty($plotsDetails->broker_id))
                     <a href='{{ url("admin/plots/editPlotsNumber/$plotsDetails->id") }}' class="btn btn-primary">Edit Plot Buy Detail</a>
                    @endif
                    
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
            @include('admin.pages.plot.payment.include.payment-tab')
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
                     <h5 class="m-0">Manage New Plots Payment Details</h5>
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
                    <form method="POST" action="{{ route('admin.plots.addPlotPaymentHistory') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="plotNumberID" id="plotNumberID" value="{{ $plotsDetails->id ?? 0 }}" readonly="readonly" />
                        <input type="hidden" name="emi_status" id="emi_status" value="{{ $plotsDetails->emi_status ?? NULL}}" readonly="readonly" />
                        <div>
                           <div class="colo-sm-12">
                              @if($plotsDetails->emi_status == 1)
                              <div class="row">     
                                 <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="checkbox" 
                                                name="installment_status" 
                                                id="installment_status" 
                                                value="1" />
                                        <label>Installment Payment  </label>
                                    </div>
                                 </div>
                              </div>
                              <div class="row" style="display: none;" id="installmentNUmberDiv">     
                                 <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Installment Number <span class="text-danger">*</span> </label>
                                         <input type="text" 
                                                class="form-control" 
                                                name="installment_number" 
                                                id="installment_number" 
                                                value="{{$installmentNumber}}" 
                                                 />
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
                                             <option value="1"> Cheque </option>
                                             <option value="2"> Cash </option>
                                             <option value="3"> Net Banking </option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label> Plot Value <span class="text-danger">*</span> </label>
                                       <div class="input-group">
                                          <input type="number" class="form-control" placeholder="Total Plot Amount" name="total_plot_amount" id="total_plot_amount" value="{{ $plotsDetails->plot_value ?? 0 }}" required="required" readonly="readonly" />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row" style="display:none;" id="referenceNumberDiv">
                                 <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Enter the Check/ Net Banking Reference Number </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" 
                                                placeholder=" Check/ Net Banking Reference Number" 
                                                name="reference_number" 
                                                id="reference_number" 
                                                value="{{ old('reference_number') }}" />
                                        </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Branch Name </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Branch Name" name="branch_name" id="branch_name" value="{{ old('branch_name') }}" />
                                        </div>
                                    </div>
                                 </div>
                            </div>
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Pay Amount  <span class="text-danger">*</span> </label>
                                       <div class="input-group">
                                          <input type="number" class="form-control" placeholder="Payment Amount" name="payment_amount" id="payment_amount" value="{{ old('payment_amount') }}" required="required"  />
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Remain Payment Amount </label>
                                       <div class="input-group">
                                           <input type="number" class="form-control" placeholder="Remain Payment Amount" id="remain_payment_amount" name="remain_payment_amount" value="{{ $remainAmount ?? 0 }}" required="required"   />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Select Date  <span class="text-danger">*</span></label>
                                       <div class="input-group">
                                          <input type="date" class="form-control" placeholder="Select date" name="payment_date" value="{{ old('payment_date') }}" required="required"  />
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Choose File Cheque / Payment Screenshots </label>
                                       <div class="input-group">
                                          <input type="file" class="form-control" name="file" />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label>Comments </label>
                                 <textarea name="bank_details" id="bank_details" class="form-control" placeholder="Comments" rows="5">{{ old('bank_details') }}</textarea>
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
   
   $(document).on('change','#payment_amount',function(e){
    	var paymentAmount = $(this);
		var paidAmount = paymentAmount.val();
		if(paidAmount > 0){
			remain_payment_amount = parseInt($('#remain_payment_amount').val()) -  parseInt(paidAmount);
		   $('#remain_payment_amount').val(remain_payment_amount);
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