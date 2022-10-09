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
              <li class="breadcrumb-item active">Agent Details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content header_margin">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-body">
                  <h6 class="card-title"><strong>Agent Details </strong></h6>
                  <div class="col-lg-12" style="margin-top:50px;">
                       <table class="table table-bordered">
                          <tr>
                            <th>Agent </th>
                            <td>{{ Str::ucfirst($agentDetail->f_name)  ?? "N/A"}} </td>
                            <th>Mobile Number </th>
                            <td>{{ $agentDetail->mobile ?? "N/A"}} </td>
                          </tr>
                      </table>
                      
                    </div>
                  <h6 class="card-text"></h6>
                  
                  <a href='{{ url("head_agent/agents") }}' class="btn btn-primary">Back</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
    <div class="content header_margin">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Agent Activity list</h5>
              </div>
                <div class="card-body">
                  @if(Session::has('msg'))
                  {!!  Session::get("msg") !!}
                  @endif
                  <table class="table table-bordered table-hover" id="example1" >
                    <thead>
                        <tr>
                          <th>Society</th>
                          <th>Block</th>
                          <th>Plot Number</th>
                          <th>Status</th>
                          <th>Till Hold Date</th>
                          <th>Buyer Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($plotsList as $plot)
                            <tr>
                              <td><a href='<?php echo url("partner/block/$plot->society_id"); ?>'>{{  $plot->name ?? "N/A" }}</a></td>
                              <td><a href="<?php echo url("partner/plots/$plot->society_plot_id"); ?>">{{  $plot->title ?? "N/A" }}</a></td>
                              <td><a target="_blank" href='javascript::void();'>{{  $plot->plot_number ?? "N/A" }}</a></td>
                              <td>
                              	@if(array_key_exists($plot->booking_status , $bookingStatus))				
                                  {{ $bookingStatus[$plot->booking_status] ?? "N/A" }}
                                @else
                                	{{ "N/A" }}
                                @endif
                              </td>
                              <td>
                                  @if(!empty($plot->hold_date))
                                    {{ \Carbon\Carbon::parse($plot->hold_date)->format(config('app.date_format')) ?? "N/A" }}
                                  @else
                                    {{"N/A"}}
                                  @endif
                                </td>
                              <td>{{  $plot->buyer_name ?? "N/A" }}</td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                    <tfoot>
                         <tr>
                          <th>Society</th>
                          <th>Block</th>
                          <th>Plot Number</th>
                          <th>Status</th>
                          <th>Till Hold Date</th>
                          <th>Buyer Name</th>
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