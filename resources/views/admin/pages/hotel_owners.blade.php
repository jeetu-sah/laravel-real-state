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
                <h5 class="m-0">Hotel Owners</h5>
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
                          <th>User Name</th>
                          <th>Email</th>
                          <th>Mobile</th>
                          <th>Status</th>
                          
                          
                        </tr>
                    </thead>
                    <tbody>
                      @forelse($hotel_owners as $howner)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td><a href='{{ url("admin/hotel_lists/$howner->token_id") }}'>{{ $howner->f_name.' '.$howner->l_name }} 
                            {{ '['.sHelper::hotel_owner_id($howner->id).']' }}</a></td>
                          <td>{{ $howner->user_name }}</td>
                          <td>{{ $howner->email }}</td>
                          <td>{{ $howner->mobile }}</td>
                          <td>
                           <select name="owner_status" class="owner_status form-control">
                             
                             <option @if($howner->user_status == 'P') selected @endif value="{{ 'P@'.$howner->id }}">Pending</option>
                             <option @if($howner->user_status == 'A') selected @endif value="{{ 'A@'.$howner->id }}">Active</option>
                           </select>
                            

                          </td>
                          
                        </tr>
                        @empty
                        <tr>
                          <td colspan="6">No record found !!!</td>
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
  $(document).on('change','.owner_status', function (e){
         var stats = $(this).val();
          $.ajax({
              url: "{{ route('admin.owner_status') }}",
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