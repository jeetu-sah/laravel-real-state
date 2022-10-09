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
    
    <!-- Main content -->
    <div class="content header_margin">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Hotel Lists</h5>
              </div>
                <div class="card-body">
                  @if(Session::has('msg'))
                  {!!  Session::get("msg") !!}
                  @endif
                  <table class="table table-bordered table-striped" id="laravel_datatable">
                    <thead>
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Mobile</th>
                          <th>Website</th>
                          <th>Address</th>
                          <th>Status</th>
                          
                          
                        </tr>
                    </thead>
                    <tbody>
                      @forelse($hotels as $hotel)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td><a href='{{ url("admin/hotel_detail/$hotel->id") }}'>{{ $hotel->name }}</a></td>
                          <td>{{ $hotel->email }}</td>
                          <td>{{ $hotel->phone_number }}</td>
                          <td>{{ $hotel->website_link }}</td>
                          <td>{{ $hotel->address }}</td>
                          <td>
                            <select name="hotel_status" class="hotel_status form-control">
                             
                             <option @if($hotel->status == 'P') selected @endif value="{{ 'P@'.$hotel->id }}">Pending</option>
                             <option @if($hotel->status == 'A') selected @endif value="{{ 'A@'.$hotel->id }}">Active</option>
                           </select>
                          </td>
                          
                        </tr>
                        @empty
                        <tr>
                          <td colspan="7">No record found !!!</td>
                        </tr>
                        @endforelse
                        
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
@push('scripts')
<script src="{{ asset('public/admin_webu/plugins/jquery/jquery.min.js') }}"></script>
<script>
  $(document).on('change','.hotel_status', function (e){
         var stats = $(this).val();
          $.ajax({
              url: "{{ route('admin.hotel_status') }}",
              type: "GET",           
              data: {stats:stats},
              success: function(data){
                 var parseJson = jQuery.parseJSON(data); 
                  if(parseJson.status == 200){
                      alert(parseJson.msg);
                  }else if(parseJson.status == 100){
                      alert(parseJson.msg);
                  }
               }
              });
         
     });
</script>