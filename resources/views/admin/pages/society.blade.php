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
          <div class="row">
          	<div class="col-lg-12">
           	    <a href="{{ url('admin/add_society') }}" data-toggle="tooltip" title="Add Society" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-plus"></i> 
                  Create New Society
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
                <h5 class="m-0">Society list</h5>
              </div>
                <div class="card-body">
                  @if(Session::has('msg'))
                  {!!  Session::get("msg") !!}
                  @endif
                  <table class="table table-bordered table-striped table-responsive" id="society-list">
                    <thead>
                        <tr>
                          <th>Society ID</th>
                          <th>Name</th>
                          <th>Society Map</th>
                           <th>Society PDF Map</th>
                          <th>Number of Plots</th>
                          <th>Priority</th>
                          <th>Location</th>
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
$(document).on('click','.remove_society',function(){
   var con = confirm('Are you sure want to remove this Society ?');
   if(con == true){
	   var societyid = $(this).data('societyid');
	   url = `${base_url}/admin/remove_society/${societyid}`;
	   window.location.href = url;
	   console.log(url);
	 }
});


/*End*/	
	
$('#society-list').DataTable({
	"processing": true,
	"serverSide": true,
  "sScrollX": "100%",
  "sScrollXInner": "110%",
  "bScrollCollapse": true,
	"ajax":{
			 "url": "{{ route('admin.scietyList') }}",
			 "dataType": "json",
			 "type": "GET",
			 "data":function(d){
			    d.role_id = 1;
			 },
		   },
	"columns": [
		   { data:'id',orderable:false},
           { data:'name'},
		   { data:'map'},
		   { data:'pdfmap'},
           { data:'numberOfPlots'},
           { data:'priority'},
	       { data:'location',orderable:false},
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