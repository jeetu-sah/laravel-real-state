@extends('admin.component.master')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @if($societyDetails != NULL)
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
                <input type="hidden" name="societyID" id="societyID" value="{{ $societyDetails->id }}" />
                <h6 class="card-title"><strong>Society Details</strong></h6>
                    <h6 class="card-text">{{ $societyDetails->name }}.</h6>
                    <h6 class="card-text">{{ $societyDetails->location ?? "N/A" }}.</h6>
                    <h6 class="card-text">{{ $societyDetails->number_of_plots ?? "" }}.</h6>
                    <a href="{{ url('admin/society') }}" class="btn btn-primary">Back</a>
                  </div>
                </div>
            </div>
          </div>
        </div>
    </div>
    @include('admin.pages.component.society_nav')

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
                  <input type="hidden" name="societyid" id="societyid" value="{{$societyDetails->id ?? 0 }}">
                  <table class="table table-bordered table-striped" id="rooms-list">
                    <thead>
                        <tr>
                          <th>ID</th>
                          <th>Title</th>
                          <th>Room Area</th>
                          <th>Plot size by gaj</th>
                          <th>Plot Value</th>
                          <th>Number of plots</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    
                     <tfoot>
                        <tr>
                          <th>ID</th>
                          <th>Title</th>
                          <th>Room Area</th>
                          <th>Plot size by gaj</th>
                          <th>Plot Value</th>
                          <th>Number of plots</th>
                          <th>Action</th>
                        </tr>
                    </tfoot>
                  </table>
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
@stop
@section('script')
 @parent
<script>
$(document).ready(function(e) {
/*remove partner list script */
$(document).on('click','.remove_plots',function(){
   var con = confirm('Are yousure want to remove this plot ?');
   if(con == true){
	   var plotid = $(this).data('plotid');
	   url = `${base_url}/admin/plots/removePlot/${plotid}`;
	   window.location.href = url;
	   console.log(url);
	 }
});


/*End*/	
	
$('#rooms-list').DataTable({
	  "processing": true,
	  "serverSide": true,
    "sScrollX": "100%",
    "sScrollXInner": "110%",
    "bScrollCollapse": true,
	"ajax":{
			 "url": "{{ route('admin.plots.roomsList') }}",
			 "dataType": "json",
			 "type": "GET",
			 "data":function(d){
			    d.societyid = $("#societyid").val();
			 },
		   },
	"columns": [
		{ data:'sn',orderable:false},
        { data:'title'},
        { data:'room_area'},
        { data:'plot_size_by_gaj'},
        { data:'plot_value'},
	    { data:'number_of_plot',orderable:false},
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