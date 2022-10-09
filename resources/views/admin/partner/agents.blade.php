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
              <li class="breadcrumb-item active">Head Agent</li>
              <li class="breadcrumb-item active">Agent List</li>
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
                <h5 class="m-0">Agent list</h5>
              </div>
                <div class="card-body">
                  @if(Session::has('msg'))
                  {!!  Session::get("msg") !!}
                  @endif
                    <table id="example1"  class="table table-bordered table-hover">
                    <thead>
                         <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Mobile</th>
                          <th>Email</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($agentList as $agent)
                        <tr>
                          <td><a href='{{ url("head_agent/agent/$agent->id") }}'>{{ $agent->user_id }}</a></td>
                          <td>{{ sHelper::getFullName($agent) }}</td>
                          <td>{{ $agent->mobile ?? "N/A" }}</td>
                          <td>{{ $agent->email ?? "N/A" }}</td>
                          <td><a class="btn btn-primary" href="{{ url("head_agent/agent/$agent->id") }}">Agents Activity</a></td>
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Mobile</th>
                          <th>Email</th>
                          <th>Action</th>
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
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>
@endsection