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
              <li class="breadcrumb-item active">{{  $plotsDetails->societyBlock->societyDetail->name ?? "N/A" }}</li>
              <li class="breadcrumb-item active">{{  $plotsDetails->societyBlock->title ?? "N/A" }}</li>
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
            @if(($plotsDetails->paymentHistory->count() > 0) && !empty($plotsDetails->buyer_id))
               @if(empty($plotsDetails->emi_status))
                  <a href='{{ url("common/printInvoice/$plotsDetails->id") }}' data-toggle="tooltip" title="Print Invoice" class="btn btn-warning float-right" style="margin-right:5px;">
                     <i class="fas fa-print"></i> 
                     Print Invoice 
                  </a>
               @endif
            @endif
            
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
                 @if($plotsDetails->paymentHistory->count() > 0)
                       @include('admin.pages.component.paymentHistory')
                  @else
                       @include('admin.pages.component.paymentDetails')
                 @endif
                  
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
   $(document).on('change','#broker',function(e){
	  var brokerID = $(this).val();
	  var plotValue = $("#total_plot_amount").val();
	  $("#broker_commision").val(0);
	  $.ajax({
			url:"{{ route('common.calculateCommission') }}",
			type: "GET",
			data: {brokerID:brokerID ,plotValue:plotValue},
			success: function (data) {
				$("#broker_commision").val(data);
			},
			error: function(xhr, error){
			  alert("Something went wrong please try again !!!");
			},
			complete: function(){
			  //$('#send_otp_btn').html('Submit').attr('disabled' , false);
			}
	  });
   });
   $(document).on('change','#payment_amount',function(e){
    	var paymentAmount = $(this);
		var paidAmount = paymentAmount.val();
		if(paidAmount > 0){
			remain_payment_amount = parseInt($('#remain_payment_amount').val()) -  parseInt(paidAmount);
		   $('#remain_payment_amount').val(remain_payment_amount);
		}
   });
 
});
</script>
@endsection