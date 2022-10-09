@extends('admin.component.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
@if($plotDetail != NULL)
{{-- dd($response) --}}
<!-- Content Header (Page header) -->
<div class="content-header  navbar-white">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6  float-sm-right">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Dashboard</li>
              <li class="breadcrumb-item active">{{  $response['plotsDetail']->plotSociety->name ?? "N/A" }}</li>
              <li class="breadcrumb-item active">{{  $response['plotsDetail']->plotBlock->title ?? "N/A" }}</li>
              <li class="breadcrumb-item active">{{  $response['plotsDetail']->plot_number ?? "N/A" }}</li>
            </ol>
         </div>
      </div>
   </div>
</div>
<!-- Main content -->
<div class="content header_margin">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-body">
                  <h6 class="card-title"><strong>Plot Details Details</strong></h6>
                  <div class="col-lg-12" style="margin-top:50px;">
                       @include('admin.pages.component.editPlotTableDetails')
                    </div>
                  <h6 class="card-text"></h6>
                  <a href='{{ route('admin.plot.plot-detail',[$plotDetail->id]) }}' 
                        class="btn btn-primary">Back</a>
                        
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
            <div class="card card-primary card-outline">
               <div class="col-sm-12">
                  <div class="card-header">
                     <h5 class="m-0">Edit Payment Detail </h5>
                  </div>
                   @if(Session::has('msg'))
                    {!!  Session::get("msg") !!}
                   @endif
                    @if ($errors->any())
                     <div class="alert alert-danger">
                        <ul>
                           @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                           @endforeach
                        </ul>
                     </div>
                     @endif
                   <div class="card-body">
                     <form method="POST" action="{{ route('admin.plots.editPlotPaymentDetail') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="plotNumberID" id="plotNumberID" value="{{ $plotDetail->id ?? 0 }}" readonly="readonly" />
                            <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select booking Status <span class="text-danger">*</span> </label>
                                        <div class="input-group">
                                            <select class="form-control booking_status" name="booking_status">
                                                @foreach($plotDetail->plotsBookingStatusArr as $key=>$bookingStatus)
                                                <option value="{{$key}}" {{ ($plotDetail->booking_status == $key) ? 'selected' : "" }}>{{ $bookingStatus }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select booking Date <span class="text-danger">*</span> </label>
                                        <div class="input-group">
                                           <input type="date" class="form-control" placeholder="Select date" name="booking_date" value="{{ $bookingDate }}">
                                        </div>
                                    </div>
                                 </div>
                            </div>
                            <div class="row">
                               <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Select Broker Name  </label>
                                       <div class="input-group">
                                          <select class="form-control broker" name="broker" id="broker">
                                             @foreach($plotDetail->brokerList as $broker)
                                             <option value="{{$broker->id}}" {{ ($plotDetail->broker_id == $broker->id) ? 'selected' : "" }} >{{$broker->f_name}}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Broker Commission <span class="text-danger">*</span></label>
                                       <div class="input-group">
                                          <input type="text" class="form-control" placeholder="Broker Commission" name="broker_commision" id="broker_commision" required="required" value="{{ !empty($plotDetail->broker_commission) ? $plotDetail->broker_commission : $brokerCommission }}" />
                                       </div>
                                    </div>
                                 </div>
                            </div>
                            <div class="row">     
                                 <div class="col-sm-12">
                                    <div class="form-group">
                                       <label>Select Buyer <span class="text-danger">*</span></label>
                                       <div class="input-group">
                                            <select class="form-control buyer" name="buyer" id="buyer">
                                             @foreach($plotDetail->buyer as $buyer)
                                                <option value="{{$buyer->id}}" {{ ($plotDetail->buyer_id == $buyer->id) ? 'selected' : "" }}>{{$buyer->f_name}}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                           </div>
                            
                           @if($plotDetail->emi_status == 1)
                           <div style="margin-top:50px;">
                              <div class="colo-sm-12">
                                 <label>EMI Details</label>
                                 <hr />
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>Down Payment Amount <span class="text-danger">*</span> </label>
                                          <div class="input-group">
                                             <input type="number" class="form-control" placeholder="Down Payment Amount" name="down_payment_amount" id="down_payment_amount" value="{{ $plotDetail->down_payment_amount ?? 0 }}" />
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label> Number of EMI in Month </label>
                                          <div class="input-group">
                                             <input type="number" class="form-control" placeholder="Number of EMI" name="number_of_emi" id="number_of_emi" value="{{ $plotDetail->number_of_emi ?? 0 }}" />
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <div class="form-group">
                                          <label>EMI Payment Amount <span class="text-danger">*</span> </label>
                                          <div class="input-group">
                                             <input type="number" class="form-control" placeholder="EMI Payment Amount" name="emi_payment_amount" id="emi_payment_amount" value="{{ $plotDetail->payment_of_emi ?? 0 }}" />
                                          </div>
                                       </div>
                                    </div>
                                 
                                 </div>
                              </div>
                              <hr />
                           </div>
                           @endif
                              <div class="form-group">
                                 <div class="input-group">
                                    <button type="submit" name="editPlotDetail" class="btn btn-success">Edit Plot Detail </button>
                                 </div>
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
});
</script>
@endsection
