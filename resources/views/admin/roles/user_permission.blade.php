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
              <li class="breadcrumb-item active">Dashboard</li>
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
                 <input type="hidden" name="userid" id="userid" value="{{ $user_detail->id ?? 0 }}" readonly="readonly" />
                <span class="card-text d-block"><strong>Name:</strong> {{ sHelper::getFullName($user_detail) }}</span>
                <span class="card-text  d-block"><strong>User Name :</strong> {{ $user_detail->user_name ?? "N/A" }}</span>
                <span class="card-text  d-block"><strong>Email :</strong> {{ $user_detail->email ?? "N/A" }}</span>
                <span class="card-text  d-block"><strong>mobile :</strong> {{ $user_detail->mobile ?? "N/A" }}</span>
                <span class="card-text  d-block"><strong>Status :</strong> {{ $user_detail->user_status ?? "N/A" }}</span>
          		  
          </div>
    		  </div>
    		</div>
    	</div>
     @endif
     </div>   
    </div>
    <div class="content" style="margin-top:0px;">
    	<div class="container-fluid">
          <div class="row">
          	<div class="col-lg-12">
           	 <a href='{{ url("admin/roles/user_permission/$user_detail->id?page=roles") }}' data-toggle="tooltip" title="Roles" class="<?php if($sub_page == "user_roles"){ echo "btn btn-success"; }else{ echo "btn btn-primary"; }   ?> float-left" style="margin-right: 5px;">
                <i class="fas fa-list"></i> 
              Roles List
              </a>
           	 <a href='{{ url("admin/roles/user_permission/$user_detail->id?page=user_permission") }}' data-toggle="tooltip" title="Permission" class="<?php if($sub_page == "user_permission"){ echo "btn btn-success"; }else{ echo "btn btn-primary"; } ?> float-left" style="margin-right: 5px;">
                <i class="fas fa-list"></i> 
              Permission List
              </a>
            </div>
          </div>
        </div>
    </div>
    <!-- Main content -->
     @if(Session::has('user_msg'))
      {!!  Session::get("user_msg") !!}
     @endif
     @if($sub_page != NULL)
     	@include("admin.roles.component.$sub_page")
     @endif
  <!-- /.content-wrapper -->
@stop
@section('script')
 @parent
<script>
/*for user permission script start*/
$(document).ready(function(e) {
/*Allocate or deallocate permissin*/
$(document).on('click','.select_permission',function(){
  var userid = $("#userid").val();
  var permissionid = $(this).val();
  if($(this).is(':checked')){
	  $(this).prop('checked',true);
    var permission = "allocate";
	}
	else{
	 $(this).prop('checked',false);
    var permission = "deallocate";
	} 
	$.ajax({
		url:"{{ route('admin.roles.allocate_deallocate_permissin_to_user') }}",
		type: "GET",
		data: {permission:permission,userid:userid,permissionid:permissionid},
		success: function (data) {
			alert(data);
		},
		error: function(xhr, error){
			//$("#otp_result_response").html("<div class='notice notice-danger notice'><strong>Wrong </strong> Something went wrong , please try again  !!! </div>");
			//$("#otp_div").show();
		},
		complete: function(){
			//$('#send_otp_btn').html('Submit').attr('disabled' , false);
		}
	}); 
});
/*End*/
/*Select single roles and assign and deassign*/
$(document).on('click','.select_checkbox',function(){
  var userid = $("#userid").val();
  var rollid = $(this).val();
  if($(this).is(':checked')){
	  $(this).prop('checked',true);
	  $(".select_checkbox_permission").prop('checked',true);
      var roles = "allocate";
	}
	else{
	 $(this).prop('checked',false);
       var roles = "deallocate";
	   $(".select_checkbox_permission").prop('checked',false);
	} 
	$.ajax({
		url:"{{ route('admin.roles.allocate_deallocate_role_to_user') }}",
		type: "GET",
		data: {roles:roles,userid:userid,rollid:rollid},
		success: function (data) {
			alert(data);
		},
		error: function(xhr, error){
			//$("#otp_result_response").html("<div class='notice notice-danger notice'><strong>Wrong </strong> Something went wrong , please try again  !!! </div>");
			//$("#otp_div").show();
		},
		complete: function(){
			//$('#send_otp_btn').html('Submit').attr('disabled' , false);
		}
	}); 
});
/*End*/	
	
/*Allocate or Deallocate roles to users*/
$(document).on('click','.select_all',function(){
  var userid = $("#userid").val();
  if($(this).is(':checked')){
	  $(".select_checkbox").prop('checked',true);
    var roles = "allocate";
	}
	else{
	 $(".select_checkbox").prop('checked',false);
    var roles = "deallocate";
	} 
	$.ajax({
		url:"{{ route('admin.roles.allocate_deallocate_all_roles') }}",
		type: "GET",
		data: {roles:roles,userid:userid},
		success: function (data) {
			alert(data)
		},
		error: function(xhr, error){
			//$("#otp_result_response").html("<div class='notice notice-danger notice'><strong>Wrong </strong> Something went wrong , please try again  !!! </div>");
			//$("#otp_div").show();
		},
		complete: function(){
			//$('#send_otp_btn').html('Submit').attr('disabled' , false);
		}
	}); 
});
/*End*/

/*permission list and */
$('#permission-table').DataTable({
	"processing": true,
	"serverSide": true,
	"ajax":{
			 "url": "{{ route('admin.roles.user_permission') }}",
			 "dataType": "json",
			 "type": "GET",
			 "data":function(d){
				d.userid = $('#userid').val();
			 },
		   },
	"columns": [
		{ data:'sn',orderable:false},
        { data:'name'},
        { data:'display_name'},
		{ data:'description',orderable:false},
	],
	'columnDefs': [ {
		'targets': [0,3], /* column index */
		'orderable': false, /* true or false */
	}]	 
});
/*for Users roles script start*/
$('#roles-table').DataTable({
	"processing": true,
	"serverSide": true,
	"ajax":{
			 "url": "{{ route('admin.roles.user_roles') }}",
			 "dataType": "json",
			 "type": "GET",
			 "data":function(d){
				d.userid = $('#userid').val();
			 },
		   },
	"columns": [
		{ "data": "sn" },
		{ "data": "name" },
		{ "data": "display_name" },
		{ "data":'description'},
	],
	'columnDefs': [ {
		'targets': [0,3], /* column index */
		'orderable': false, /* true or false */
	}]	 
});
/*For roles script End*/	
});
</script>
@endsection