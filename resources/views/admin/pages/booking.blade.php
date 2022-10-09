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
           <!-- 	 <a href="{{ url('door-plus-admin/save_categories') }}" data-toggle="tooltip" title="Add category" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-plus"></i> 
                  </a> -->
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
                <h5 class="m-0">Booking List</h5>
              </div>
                <div class="card-body">
                  <table class="table table-bordered table-striped" id="users-table">
                    <thead>
                        <tr>
                          <th>ID</th>
                          <th>Booking Date</th>
                          <th>Name</th>
                          <th>Service Name</th>
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
   $('#users-table').DataTable({
    serverSide: true,
    ajax: "{{ url('door-plus-admin/booking') }}",
    columns: [
        { data:'sn'},
        { data:'appointment_date'},
        { data:'name' },
        { data:'service', orderable: false },
    ],
}); 
});


</script>
@endsection