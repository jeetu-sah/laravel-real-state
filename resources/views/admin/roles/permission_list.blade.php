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
    @role('super-admin')
    <div class="content header_margin">
    	<div class="container-fluid">
          <div class="row">
          	<div class="col-lg-12">
              @permission('create-permission')
              <a href="{{ url('admin/roles/add_permission') }}" data-toggle="tooltip" title="Add Permission" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-plus"></i> 
              </a>
              @endpermission
            </div>
          </div>
        </div>
    </div>
    @endrole
    <!-- Main content -->
    <div class="content header_margin">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Permissions list</h5>
              </div>
                <div class="card-body">
                  @if(Session::has('msg'))
                  {!!  Session::get("msg") !!}
                  @endif
                  <table class="table table-bordered table-striped" id="feature-table">
                    <thead>
                        <tr>
                          <th>SN</th>
                          <th>Name</th>
                          <th>Display Name</th>
                          <th>Description</th>
                        </tr>
                    </thead>
                    <tfoot>
                      <tr>
                          <th>SN</th>
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
   $('#feature-table').DataTable({
    serverSide: true,
	ajax:"{{ route('admin.roles.permission_list') }}",
    columns: [
        { data:'sn',orderable:false},
        { data:'name'},
        { data:'display_name'},
		{ data:'description',orderable:false},
    ],
}); 
});
</script>
@endsection