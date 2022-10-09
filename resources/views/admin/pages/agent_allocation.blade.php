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
              <li class="breadcrumb-item active">Admin </li>
              <li class="breadcrumb-item active">Agent Allocation </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content header_margin">
        <div class="container-fluid">
            @if($user_detail != NULL)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-bottom:5px;"><strong>User Details : </strong></h5>
                                <input type="hidden" name="headAgentID" id="headAgentID" value="{{ $user_detail->id ?? 0 }}" readonly="readonly" />
                                <span class="card-text d-block"><strong>Name:</strong> {{ sHelper::getFullName($user_detail) }}</span>
                                <span class="card-text  d-block"><strong>User Name :</strong> {{ $user_detail->user_name ?? "N/A" }}</span>
                                <span class="card-text  d-block"><strong>Email :</strong> {{ $user_detail->email ?? "N/A" }}</span>
                                <span class="card-text  d-block"><strong>mobile :</strong> {{ $user_detail->mobile ?? "N/A" }}</span>
                                <span class="card-text  d-block"><strong>Status :</strong> {{ $user_detail->user_status ?? "N/A" }}</span> 
                                <a href="{{ url('admin/users_allocation') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>   
    </div>
    <div class="content header_margin">
    	<div class="container-fluid">
          <div class="row">
          	<div class="col-lg-12">
              	 @include('admin.pages.component.usersNav')
            </div>
          </div>
        </div>
    </div>
    <!-- Main content -->
     @if(Session::has('msg'))
      {!!  Session::get("msg") !!}
     @endif
        <!-- Main content -->
        <div class="content header_margin">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">Agent list</h5>
                            </div>
                            <div class="card-body">
                            @if(Session::has('msg'))
                            {!!  Session::get("msg") !!}
                            @endif
                            @if($user_detail != NULL)
                                <table class="table table-bordered table-striped" id="permission-table">
                                    <thead>
                                        <tr>
                                        <th>SN.</th>
                                        <th>Agent ID</th>
                                        <th>Name</th>
                                        <th>Login ID</th>
                                        <th>Mobile</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>SN. </th>
                                            <th>Agent ID</th>
                                            <th>Name</th>
                                            <th>Login ID</th>
                                            <th>Mobile</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
                                @else
                                <h2>Something went wrong , please try again !!!</h2>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop
@section('script')
 @parent
<script>
/*for user permission script start*/
$(document).ready(function(e) {
/*Allocate or deallocate permissin*/
$(document).on('click','.select_agent',function(){
  var userid = $(this).val();
  var headAgentID = $("#headAgentID").val();
  if($(this).is(':checked')){
	  $(this).prop('checked',true);
      var action = "allocate";
	}
	else{
	 $(this).prop('checked',false);
     var action = "dellocate";
	} 
	$.ajax({
		url:"{{ route('admin.userAllocation.agentAllocateToHeadagent') }}",
		type: "GET",
		data: {action:action,userid:userid,headAgentID:headAgentID},
		success: function (data) {
		alert(data);
		},
		error: function(xhr, error){
			$("#otp_result_response").html("<div class='notice notice-danger notice'><strong>Wrong </strong> Something went wrong , please try again  !!! </div>");
		}
	}); 
});
/*End*/
	
/*permission list and */
$('#permission-table').DataTable({
	"processing": true,
	"serverSide": true,
    "sScrollX": "100%",
    "sScrollXInner": "110%",
    "bScrollCollapse": true,
	"ajax":{
			 "url": "{{ route('admin.userAllocation.agentAllocation') }}",
			 "dataType": "json",
			 "type": "GET",
			 "data":function(d){
				d.headAgentID = $('#headAgentID').val();
			 },
		   },
	"columns": [
		{ data:'sn',orderable:false},
		{ data:'agentid',orderable:false},
        { data:'name'},
        { data:'loginid'},
		{ data:'mobile',orderable:false},
	],
	'columnDefs': [ {
		'targets': [0,3], /* column index */
		'orderable': false, /* true or false */
	}]	 
});
	
});
</script>
@endsection