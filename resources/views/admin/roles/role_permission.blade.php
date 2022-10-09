@extends('admin.component.master')
@section('content')
<!--<h1>rolles permission</h1>-->
  <!-- Content Wrapper. Contains page content -->
<input type="text" name="role_id" id="role_id" value="{{ $role_detail->id ?? 0}}" />  
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
    	<div class="row">
        	<div class="col-lg-12">
   			  <div class="card">
          		<div class="card-body">
           		 <h5 class="card-title"><strong>Role Details : </strong></h5>
           		 <span class="card-text d-block mt-5"><strong>Name:</strong> {{$role_detail->name ?? "N/A" }}</span>
               <span class="card-text d-block mb-4"><strong>Display Name :</strong> {{$role_detail->display_name ?? "N/A" }}</span>
          		  <a href='{{ url("admin/roles/add_roles/$role_detail->id") }}' class="btn btn-primary">Edit</a>
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
                <h5 class="m-0">Role Permission list</h5>
              </div>
                <div class="card-body">
                  @if(Session::has('msg'))
                  {!!  Session::get("msg") !!}
                  @endif
                  <table class="table table-bordered table-striped" id="permission-table">
                    <thead>
                        <tr>
                          <th>Select All&nbsp<div 
                          <div class="form-group">
                           <input type="checkbox" class="select_all_permission" name="select_all_permission" />
                           </div>
                          </th>
                          <th>Name</th>
                          <th>Display Name</th>
                          <th>Description</th>
                        </tr>
                    </thead>
                    <tfoot>
                      <tr>
                            <th>Select All&nbsp<div class="form-group">
                           <input type="checkbox" class="select_all" name="select_all" />
                    </div></th>
                          <th>Name</th>
                          <th>Display Name</th>
                          <th>Description</th>
                        </tr>
                  </tfoot>
                    <tbody>
                    </tbody>
                  </table>
                </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@stop
@section('script')
 @parent
<script>
$(document).ready(function(e) {
/*assign single permission to login*/
 $(document).on('click','.select_checkbox_permission',function(){
  var rollid = $("#role_id").val();
  
  if($(this).is(':checked')){
       var permission = "allocate";
	}
  else{
	   var permission = "deallocate";
    } 
   var permission_id = $(this).val();
	$.ajax({
		url:"{{ route('admin.roles.allocate_deallocate_single_permissin_to_roles') }}",
		type: "GET",
		data: {permission:permission,rollid:rollid,permission_id:permission_id},
		success: function (data) {
		},
		error: function(xhr, error){
		    $("#otp_result_response").html("<div class='notice notice-danger notice'><strong>Wrong </strong> Something went wrong , please try again  !!! </div>");
			$("#otp_div").show();
		},
		complete: function(){
			//$('#send_otp_btn').html('Submit').attr('disabled' , false);
		}
	}); 
});
/*End*/
  /*assign permission to roles*/
 $(document).on('click','.select_all_permission',function(){
  var rollid = $("#role_id").val();
  if($(this).is(':checked')){
	  $(".select_checkbox_permission").prop('checked',true);
       var permission = "allocate";
	}
	else{
	 $(this).prop('checked',false);
	 $(".select_checkbox_permission").prop('checked',false);
     var permission = "deallocate";
	} 
	$.ajax({
		url:"{{ route('admin.roles.allocate_deallocate_permissin_to_roles') }}",
		type: "GET",
		data: {permission:permission,rollid:rollid},
		success: function (data) {
		},
		error: function(xhr, error){
		    $("#otp_result_response").html("<div class='notice notice-danger notice'><strong>Wrong </strong> Something went wrong , please try again  !!! </div>");
			$("#otp_div").show();
		},
		complete: function(){
			//$('#send_otp_btn').html('Submit').attr('disabled' , false);
		}
	}); 
});
/*End*/
 
$('#permission-table').DataTable({
	"processing": true,
	"serverSide": true,
	"ajax":{
			 "url": "{{ route('admin.roles.assign_role_permission') }}",
			 "dataType": "json",
			 "type": "GET",
			 "data":function(d){
				d.role_id = $('#role_id').val();
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
});
</script>
@endsection