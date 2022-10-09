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
              <li class="breadcrumb-item active">Block List</li>
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
                             <th>Number Of Plots</th>
                             <td>{{ $societyDetails->number_of_plots ?? "N/A" }}</td>
                             <th>Priority</th>
                             <td>{{ $societyDetails->priority ?? "N/A" }}</td>
                          </tr>
                      </table>
                      <input type="hidden" name="societyID" id="societyID" value="{{ $societyDetails->id }}" />
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
                  <input type="hidden" name="societyid" id="societyid" value="{{$societyDetails->id ?? 0 }}">
                  <table class="table table-bordered table-striped" id="rooms-list">
                    <thead>
                        <tr>
                          <th>ID</th>
                          <th>Title</th>
                          <th>Plot size by gaj</th>
                          <th>Number of plots</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    
                     <tfoot>
                        <tr>
                          <th>ID</th>
                          <th>Title</th>
                          <th>Plot size by gaj</th>
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
	"ajax":{
			 "url": "{{ route('partner.blockList') }}",
			 "dataType": "json",
			 "type": "GET",
			 "data":function(d){
			    d.societyid = $("#societyid").val();
			 },
		   },
	"columns": [
		{ data:'sn',orderable:false},
        { data:'title'},
        { data:'plot_size_by_gaj'},
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