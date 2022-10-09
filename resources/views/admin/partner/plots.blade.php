@extends('admin.component.master')
@section('content')
  @if($societyDetails != NULL)
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header  navbar-white">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6  float-sm-right">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Head Agent </li>
              <li class="breadcrumb-item active">Blocks</li>
               <li class="breadcrumb-item active">Plots</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content header_margin">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
              <h6 class="card-title"><strong>Society Details</strong></h6>
              <table class="table table-bordered" style="margin:0px 50px 10px 0px;">
                          <tr>
                            <th>Society Name</th>
                             <td>{{ $societyDetails->name ?? "N/A" }}</td>
                             <th>Location </th>
                             <td>{{ $societyDetails->location ?? "N/A" }}</td>
                          </tr>
                          <tr>
                             <th>Block Name</th>
                             <td>{{ $blockDetail->title ?? "N/A" }}</td>
                             <th>Plot Size In Gaj</th>
                             <td>{{ $blockDetail->plot_size_by_gaj ?? "N/A" }}</td>
                          </tr>
                      </table>
                      <input type="hidden" name="societyID" id="societyID" value="{{ $societyDetails->id }}" />
                        <input type="hidden" name="bloclID" id="bloclID" value="{{ $blockDetail->id ?? 0}}" />
                    <a href="{{ url('partner/societies') }}" class="btn btn-primary">Back</a>
                  </div>
                </div>
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
              <div class="card-header">
                <h5 class="m-0">Plots list</h5>
              </div>
                <div class="card-body">
                  @if(Session::has('msg'))
                  {!!  Session::get("msg") !!}
                  @endif
                  @include('admin.partner.component.plotNumbers')
                </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @else
  <div class="content-header  navbar-white">
  <h2 class="text-center" style="padding:100px;">Something , went wrong please try again !!!</h2>
  @endif
  <div class="modal" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
        <h4 class="modal-title">Change Booking Status</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
                    <form id="changeBookingStatusForm">
                      @csrf
                      <input type="hidden" name="plotNumberID" id="plotNumberID"  />
                       <input type="hidden" name="statusID" id="statusID"  />
                      <div class="modal-body">
                        <div id="plotNumberInfomsg">
                       		<div  style="margin-bottom:15px;" class='notice notice-info notice'><strong>Info </strong>  Are you sure want to change the Booking status  !!! </div>
						</div>
                        <div class="row" id="selectDateRow" style="display:none; margin-bottom:15px;">
                            <div class="col-md-12 form-group" style="text-align:center;">
                                <label>Select Date&nbsp;<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" placeholder="Plot Value" name="holdDate" id="holdDate" /> 
                            </div>
                        </div>
                        <div>
                          <div id="savePlotsResponse"></div>
                          <div style="text-align:center;">
                            <button style="padding:30px;" type="submit" id="saveChangeBookingStatusBtn" class="btn bg-blue ml-3">Change Status</button>
                          </div>
                        </div>
			            </div>
			              </form>
                  <div class="modal-footer">       
                </div>
              </div>
            </div>
            </div>
@stop
@section('script')
 @parent
<script>
$(document).ready(function(e) {
/*Booked or hold status change from agents*/
$(document).on('change','.booking_status',function(e){
	var bookingStatus = $(this);
	statusID = parseInt(bookingStatus.val());
	var plotNumber = bookingStatus.data('plotnumber');
	$("#statusID").val(statusID);
	$("#plotNumberID").val(plotNumber);
	if(statusID == 2){
	   $("#selectDateRow").show();
	 }
	else{
	   $("#selectDateRow").hide();
	 } 
	$('#changeStatusModal').modal({
		backdrop:'static',
		keyboard:false,
	});
});
/*End*/	
/*change the  status of plots*/
	$(document).on('submit','#changeBookingStatusForm', function(e) {
       $("#plotNumberInfomsg").html(" ");
	   //$('#saveChangeBookingStatusBtn').html(' Please wait <i class="icon-spinner2 spinner"></i>').attr('disabled', true);
      e.preventDefault();
      $.ajax({
	    	url: "{{ route('common.saveStatusOfplots') }}",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            var jsonDecode = jQuery.parseJSON(data);
            console.log(jsonDecode.msg);
            $("#plotNumberInfomsg").html(jsonDecode.msg);
            if(jsonDecode.status == 200){
              setTimeout(function(){ location.reload(); }, 1000);
            }
        },
        error:function(e , xhr , setting){
          $("#plotNumberInfomsg").html(`<div class="notice notice-danger notice"><strong>Wrong </strong>  Something , went wrong please try again !!! </div>`);
        },
        complete: function(){
          $("#saveChangeBookingStatusBtn").html(`Change Status`).attr('disabled', false);;
        }
      });
    });
	/*End*/
	
	$('#plotNumberList').DataTable({
	"processing": true,
	"serverSide": true,
	"ajax":{
			 "url": "{{ route('partner.plotsNumberList') }}",
			 "dataType": "json",
			 "type": "GET",
			 "data":function(d){
			    d.bloclID = $("#bloclID").val();
			 },
		   },
	"columns": [
		{ data:'sn',orderable:false},
        { data:'plot_number'},
        { data:'plot_value'},
		{ data:'complete_booking_status'},
        { data:'booking_status'},
        { data:'plot_size'},
        { data:'plot_area'},
       
	],
	'columnDefs': [ {
		'targets': [0,2], /* column index */
		'orderable': false, /* true or false */
	}]	 
}); 

});
</script>
@endsection