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
                <input type="hidden" name="roomID" id="roomID" value="{{ $roomsDetails->id }}" />
                <h6 class="card-title"><strong>Rooms Details</strong></h6>
                    <h6 class="card-text">Title : {{ $roomsDetails->title ?? "N/A" }}.</h6>
                    <h6 class="card-text">Rooms Area : {{ $roomsDetails->room_area ?? "N/A" }}.</h6>
                    <h6 class="card-text">Plots Size By Gaj : {{ $roomsDetails->plot_size_by_gaj ?? "" }}.</h6>
                    <a href="{{ url('admin/society') }}" class="btn btn-primary">Back</a>
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
                <a href="{{ url("admin/rooms/roomNumber/$roomsDetails->id") }}" data-toggle="tooltip" title="Add Rooms Numbers" class="btn btn-primary float-right" style="margin-right: 5px;">
                        <i class="fas fa-plus"></i> 
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
              <div class="card-header">
                <h5 class="m-0">Users list</h5>
              </div>
                <div class="card-body">
                  @if(Session::has('msg'))
                  {!!  Session::get("msg") !!}
                  @endif
                  <table class="table table-bordered table-striped" id="user-list">
                    <thead>
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Login ID</th>
                          <th>Mobile</th>
                          <th>ID Proof Type</th>
                          <th>ID Proof Number</th>
                          <th>Action</th>
                        </tr>
                    </thead>
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
/*remove partner list script */
$(document).on('click','.remove_partner',function(){
   var con = confirm('Are yousure want to remove this partners ?');
   if(con == true){
	   var partnerID = $(this).data('partnerid');
	   url = `${base_url}/admin/remove_partners/${partnerID}`;
	   window.location.href = url;
	   console.log(url);
	 }
});


/*End*/	
	
$('#user-list').DataTable({
	"processing": true,
	"serverSide": true,
	"ajax":{
			 "url": "{{ route('admin.partnerlist') }}",
			 "dataType": "json",
			 "type": "GET",
			 "data":function(d){
			    d.role_id = 1;
			 },
		   },
	"columns": [
		    { data:'sn',orderable:false},
        { data:'name'},
        { data:'login_id'},
        { data:'mobile'},
        { data:'proofType'},
	      { data:'proofNumber',orderable:false},
	      { data:'action',orderable:false},
	],
	'columnDefs': [ {
		'targets': [0,3], /* column index */
		'orderable': false, /* true or false */
	}]	 
}); 	
});
</script>
@endsection