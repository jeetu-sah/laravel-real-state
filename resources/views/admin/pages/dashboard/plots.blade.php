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
              <li class="breadcrumb-item">Dashboard</li>
              <li class="breadcrumb-item active">Plots</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content header_margin">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0"><i class="fa fa-list"></i>&nbsp;Filters</h5>
              </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Select Start Date  </label>
                            <div class="input-group">
                               <input type="date" class="form-control" name="start_date" id="start_date"  />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Select End Date </label>
                            <div class="input-group">
                               <input type="date" class="form-control" name="end_date" id="end_date"  />
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Select Payment Holder Name <span class="text-danger">*</span> </label>
                            <div class="input-group">
                                <select class="form-control" name="broker_list" id="broker_list">
                                <option value="0">Select Broker list </option>
                                  @foreach($brokerOwners as $broker)
                                    <option value="{{ $broker->id }}">{{ $broker->f_name }} </option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top:32px;">
                        <div class="form-group">
                             <div class="input-group">
                               <button class="btn btn-primary" name="search_plot" id="search_plot">Search Payment</button>
                             </div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Search by plot Number <span class="text-danger">*</span> </label>
                            <div class="input-group">
                                <input type="text"  class="form-control" name="plotNumber" placeholder="Search by plot Number" id="plotNumber" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top:32px;">
                        <div class="form-group">
                             <div class="input-group">
                               <button class="btn btn-primary" name="search_plot" id="searchPlotByNumber">Search Plot Number</button>
                             </div>
                        </div>
                    </div>
                  </div>
                </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
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
                  <table class="table table-bordered table-striped" id="plotLists">
                    <thead>
                        <tr>
                          <th>SN.</th>
                          <th>Plot Number</th>
                          <th>Block</th>
                          <th>Society</th>
                          <th>Booking Date</th>
                          <th>Status</th>
                          <th>Brokers </th>
                          <th>Buyer </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  <tfoot align="right">
                        <tr><th></th><th></th><th></th><th></th><th></th><th></th></tr>
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
@stop
@section('script')
 @parent
<script>
$(document).ready(function(e) {

$('#plotLists').DataTable({
		"processing": true,
	  "serverSide": true,
    "sScrollX": "100%",
    "sScrollXInner": "110%",
    "bScrollCollapse": true,
	"ajax":{
			 "url": "{{ route('admin.dashboard.plots') }}",
			 "dataType": "json",
			 "type": "GET",
			 "data":function(d){
			      d.broker = $("#broker_list").val();
			      d.plotNumber = $("#plotNumber").val();
            d.startDate = 2;
            d.endDate = 3;
			 },
		   },
	"columns": [
		    { data:'sn',orderable:false},
        { data:'plot_number'},
		    { data:'block'},
        { data:'society'},
        { data:'booking_date'},
        { data:'status'},
		    { data:'broker'},
		    { data:'buyer'},
	],
	'columnDefs': [ {
		'targets': [0], /* column index */
		'orderable': false, /* true or false */
	}]	 
}); 

    $(document).on('click','#searchPlotByNumber',function(e){
         e.preventDefault();
         $('#plotLists').DataTable().draw(true);
    });	
    
    $(document).on('click','#search_plot',function(e){
         e.preventDefault();
         $('#plotLists').DataTable().draw(true);
    });	

});
</script>
@endsection