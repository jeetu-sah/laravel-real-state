@extends('admin.component.master')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header  navbar-white">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6  float-sm-right">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
              <li class="breadcrumb-item active">Dashboard</li>
              <li class="breadcrumb-item active">Society Plots Number List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
   @if($plotDetails != NULL)
    <div class="content header_margin">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                 <h6 class="card-title"><strong>Block Details</strong></h6>
                    <div class="col-lg-12" style="margin-top:50px;">      
                        <input type="hidden" name="roomID" id="roomID" value="{{ $plotDetails->id }}" />
                        <input type="hidden" name="bloclID" id="bloclID" value="{{ $plotDetails->id }}" />
                  
                        <table class="table table-bordered" style="margin-top:15px;">
                          <tr>
                            <th>Block Name </th>
                             <td>{{ $plotDetails->title ?? "N/A" }} </td>
                             <th>Plot Area (in Gaj)</th>
                             <td>{{ $plotDetails->plot_size_by_gaj ?? "" }}</td>
                             <th>Number Of Plots : </th>
                             <td>{{ $plotDetails->number_of_plot ?? "0" }}</td>
                          </tr>
                          <tr>
                            <th>Society Name </th>
                             <td>{{ $plotDetails->societyDetails->name ?? "N/A" }} </td>
                             <th>Location</th>
                             <td>{{ $plotDetails->societyDetails->location ?? "N/A" }}</td>
                             <th>Number Of Plots : </th>
                             <td>{{$plotDetails->number_of_plot ?? "N/A"}}</td>
                          </tr>
                       </table>

                    <a style="margin-top:15px;" href='{{ url("admin/plots/$plotDetails->society_id") }}' class="btn btn-primary">Back</a>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
   <!-- Main content -->
   @if($plotsNumberResponse->count() > 0)
      @include('admin.pages.component.plotNumbers')
   @else
    <div class="content header_margin">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Save Plots Numbers</h5>
              </div>
                <div class="card-body">
                  @if(Session::has('msg'))
                  {!!  Session::get("msg") !!}
                  @endif
                  <div id="infoMsgResponse"></div>
                  <form  id="plotDetailsSave">
                    @csrf
                @if($plotDetails != NULL)
                 @php
                   $numberOfPlots = $plotDetails->number_of_plot
                  @endphp
                 @for($i = 1; $i <= $numberOfPlots; $i++)
                      <div class="row plotrow">
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label>Plot Number <span class="text-danger">*</span> </label>
                              <div class="input-group">
                                <input type="text" class="form-control plot_number" placeholder="Plot Number" name="plot_number" />
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label>Plot Value <span class="text-danger">*</span> </label>
                              <div class="input-group">
                                <input type="text" class="form-control plot_value" placeholder="Plot Value" name="plot_value" />
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Booking Status<span class="text-danger">*</span> </label>
                              <div class="input-group">
                               <select class="form-control booking_statusFirst" name="booking_status">
                                 @foreach($plotsBookingStatusArr as $key=>$bookingStatus)
                                   <option value="{{$key}}">{{ $bookingStatus }} </option>
                                 @endforeach
                               </select>
                              </div>
                        </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Plot Size in Gaj<span class="text-danger">*</span> </label>
                          <div class="input-group">
                            <input type="text" class="form-control plot_size" placeholder="Plot Size" name="plot_size" />
                           </div>
                        </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Plot Area<span class="text-danger">*</span> </label>
                          <div class="input-group">
                            <input type="text" class="form-control plot_area" placeholder="Plot Area" name="plot_area" />
                           </div>
                        </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                            <label>Priority<span class="text-danger">*</span> </label>
                          <div class="input-group">
                            <input type="text" class="form-control priority" placeholder="Plot Priority" name="priority" />
                           </div>
                        </div>
                          </div>
                      </div>
                 @endfor
                @endif
                <div id="savePlotResponse"></div>
                <div class="form-group">
                    <div class="input-group">
                        <button type="submit" name="save_category" id="savePlotsNumbers" class="btn btn-success">Save </button>
                    </div>
                </div>
                </form>
                </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
   @endif 
   @else
   <div class="content header_margin">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                    <h2>Something went wrong , please try  again </h2>
                </div>
                </div>
            </div>
          </div>
        </div>
    </div>
   @endif
  <!-- /.content-wrapper -->
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
 <script src="{{ asset('public/SiteJs/common.js') }}"></script>
<script>
var setBookingStatus = "{{ route('admin.plots.setBookingStatus') }}";
var saveStatusOfplots = "{{ route('common.saveStatusOfplots') }}"
<!--List of plot number list--->
$('#plotNumberList').DataTable({
	  "processing": true,
	  "serverSide": true,
    "sScrollX": "100%",
    "sScrollXInner": "110%",
    "bScrollCollapse": true,
	"ajax":{
			 "url": "{{ route('admin.plot.plot-list') }}",
			 "dataType": "json",
			 "type": "GET",
			 "data":function(d){
			    d.bloclID = $("#bloclID").val();
			 },
		   },
	"columns": [
		    { data:'sn',orderable:false},
		    { data:'emi_status',orderable:false},
        { data:'plot_number'},
        { data:'plot_value'},
        { data:'booking_status'},
        { data:'plot_size'},
        { data:'plot_area'},
		{ data:'priority'},
        { data:'action'},
	],
	'columnDefs': [ {
		'targets': [0,2], /* column index */
		'orderable': false, /* true or false */
	}]	 
}); 
<!--End-->

	$(document).ready(function(e) {
	  /*Set priority on chnage */
	  $(document).on('change','.plot_priority',function(){
	      var plot_priority = $(this);
		  var plotNumberID = plot_priority.data('plotnumber');
		  var priority = plot_priority.val();
		  $.ajax({
			   url: "{{ route('admin.plots.setPriority') }}",
			   type: "GET",        
			   data: {priority:priority,plotNumberID:plotNumberID},
			   	success: function(data){
                  //alert("Priority set Succefully !!!");
			   	}
		   	});
	   });
	  /*End*/	
    $(document).on('change','.emi_statys',function(){
       var plotNumberID = $(this);
       var plotEmiStatus = null;
       if( plotNumberID.is(':checked') ){
            plotEmiStatus = 1;
       }else{
            plotEmiStatus = null;
       }
       var plotNumber = plotNumberID.data('plotid');
       $.ajax({
			   url: "{{ route('admin.plots.setEmiStatus') }}",
			   type: "GET",        
			   data: {plotEmiStatus:plotEmiStatus,plotNumber:plotNumber},
			   	success: function(data){
                  //alert("Priority set Succefully !!!");
			   	}
		   	});
    });
		
		
      $(document).on('submit','#plotDetailsSave',function(e){
			e.preventDefault();
        $('#infoMsgResponse').html(" ");
		$('#savePlotsNumbers').html('Please wait <i class="icon-spinner2 spinner"></i>').attr('disabled' , true);
        plotsDetailsArr = []
        $('#plotDetailsSave .plotrow').each(function() {
			var plotNumber = $(this).find('.plot_number').val();
			if(plotNumber != ""){
			  	var plotValue = $(this).find('.plot_value').val();
				var plotsBookingStatus = $(this).find('.booking_statusFirst').val();
				var brokerName = $(this).find('.broker_name').val();
				var plot_size = $(this).find('.plot_size').val();
				var plot_area = $(this).find('.plot_area').val();
				let priority = $(this).find('.priority').val();
				 plotsDetailsArr.push({plotNumber:plotNumber, 
									   plotValue:plotValue,
									   plotsBookingStatus:plotsBookingStatus,
									   plotSize:plot_size,
									   plot_area:plot_area,
									   priority:priority
									  })
			}
        })
		var roomID = $("#roomID").val(); 
        $.ajax({
			url:"{{ route('admin.plots.savePlotsNumber') }}",
			type: "POST",        
			data: {roomID:roomID ,plotsDetailsArr:plotsDetailsArr},
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data){
				//console.log(data.status);
				$("#savePlotResponse").html(data.msg); 
				if(data.status == 200){
				   setTimeout(function(){ location.reload(); }, 1000);
				 }
			}	,
			error: function(xhr, error){
			   $("#savePlotResponse").html(`<div class="notice notice-danger notice"><strong>Wrong </strong>  Something , went wrong please try again !!! </div>`); 	
			}
			,complete: function(){
			   $("#savePlotsNumbers").html(`Save`).attr('disabled', false);
			}
      	});
    });
	
/*open modal popup*/
$(document).on('click','.editPlotDetails',function(e){
  e.preventDefault();
  var plotID = $(this).data('plotid');
	$.ajax({
			   url: "{{ route('admin.plots.getPlotsDetails') }}",
			   type: "GET",        
			   data: {plotID:plotID},
			   	success: function(data){
             var parseJson = jQuery.parseJSON(data);
              if(parseJson.status == 200){
				  console.log(parseJson.r);
                  $('#editPlotsForm #plotID').val(parseJson.r.id);
                  $('#editPlotsForm #plot_number').val(parseJson.r.plot_number);
                  $('#editPlotsForm #plot_value').val(parseJson.r.plot_value);
                  $('#editPlotsForm #booking_status').find(`option[value=${parseJson.r.booking_status}]`).attr('selected','selected');
				  $('#editPlotsForm #plot_size').val(parseJson.r.plot_size_in_gaj);;
				  $('#editPlotsForm #plot_area').val(parseJson.r.plot_area);
				  $('#editPlotsForm #priority').val(parseJson.r.priority);
                  $('#editPlotDetailsModal').modal({
                          backdrop:'static',
                          keyboard:false,
                  });
              } 
			   	}
		   	});
	
});
/*edit plots numbers script start*/
 $(document).on('submit', '#editPlotsForm', function(e) {
      $("savePlotsResponse").html(" ");
      $('#editPlotsBtn').html(' Please wait <i class="icon-spinner2 spinner"></i>').attr('disabled', true);
      e.preventDefault();
      $.ajax({
        url: "{{ route('admin.plots.editNewplots') }}",
        type: "POST",
		headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
		  var parseJson = jQuery.parseJSON(data);
		  $("#editPlotsResponse").html(parseJson.msg);
		  if(parseJson.status == 200){
			 setTimeout(function(){ location.reload(); }, 1000);
			}
        },
		error:function(e , xhr , setting){
		  $("#editPlotsResponse").html(`<div class="notice notice-danger notice"><strong>Wrong </strong>  Something , went wrong please try again !!! </div>`);
		},complete: function(){
		   $("#editPlotsBtn").html(`Edit Plots`).attr('disabled', false);
		}
      });
    });
/*End*/
/*End*/

/*End*/
/*open create New plots modal popup*/
$(document).on('click','#CreateNewPlots',function(){
    event.preventDefault();
	$('#AddPlotDetailsModal').modal({
				  backdrop:'static',
				  keyboard:false,
			  });
});

/*save plots number script start*/
    $(document).on('submit', '#addPlotsValue', function(e) {
      $("savePlotsResponse").html(" ");
      $('#savePlotsBtn').html(' Please wait <i class="icon-spinner2 spinner"></i>').attr('disabled', true);
      e.preventDefault();
      $.ajax({
        url: "{{ route('admin.plots.saveNewplots') }}",
        type: "POST",
		headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
		  var parseJson = jQuery.parseJSON(data);
		  $("#savePlotsResponse").html(parseJson.msg);
		  if(parseJson.status == 200){
			 setTimeout(function(){ location.reload(); }, 1000);
			}	
        },
		error:function(e , xhr , setting){
		  $("#savePlotsResponse").html(`<div class="notice notice-danger notice"><strong>Wrong </strong>  Something , went wrong please try again !!! </div>`);
		},
		complete: function(){
		   $("#savePlotsBtn").html(`Save Plots`).attr('disabled', false);
		}
      });
    });
/*End*/
});


</script>
@endsection