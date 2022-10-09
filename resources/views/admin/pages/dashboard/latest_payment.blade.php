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
              <li class="breadcrumb-item active">Latest Payment</li>
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
                                <select class="form-control" name="payment_holder_name" id="payment_holder_name">
                                <option value="0"> Main Owner list </option>
                                @foreach($mainOwners as $owner)
                                  <option value="{{ $owner->id }}">{{ $owner->f_name }} </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                             <div class="input-group">
                               <button class="btn btn-primary" name="search_payment" id="search_payment">Search Payment</button>
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
                  <table class="table table-bordered table-striped" id="latestPayment">
                    <thead>
                        <tr>
                          <th>SN.</th>
                          <th>Payment Date</th>
                          <th>Paid Amount</th>
                          <th>Plot Number</th>
                          <th>Block</th>
                          <th>Society</th>
                          <th>Broker </th>
                          <th>Buyer </th>
                          <th>Main Owner </th>
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
	
$('#latestPayment').DataTable({
		"processing": true,
	  "serverSide": true,
    "sScrollX": "100%",
    "sScrollXInner": "110%",
    "bScrollCollapse": true,
	"ajax":{
			 "url": "{{ route('admin.dashboard.latest_payment') }}",
			 "dataType": "json",
			 "type": "GET",
			 "data":function(d){
			    d.mainOwner = $("#payment_holder_name").val();
          d.startDate = $("#start_date").val();
          d.endDate = $("#end_date").val();
			 },
		   },
	"columns": [
		   { data:'sn',orderable:false},
           { data:'payment_date'},
		   { data:'paid_amount'},
           { data:'plot_number'},
           { data:'block_name'},
           { data:'society'},
		   { data:'broker'},
		   { data:'buyer'},
		   { data:'main_owner'},
       /*    { data:'action',orderable:false},*/
	],
	'columnDefs': [ {
		'targets': [0], /* column index */
		'orderable': false, /* true or false */
	}]	 
}); 

$(document).on('click','#search_payment',function(e){
  e.preventDefault();
  $('#latestPayment').DataTable().draw(true);
});	
});
</script>
@endsection