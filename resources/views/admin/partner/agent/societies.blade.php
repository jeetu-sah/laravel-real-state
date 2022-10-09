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
              <li class="breadcrumb-item active">Agent</li>
              <li class="breadcrumb-item active">Society List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  @if(Auth::user()->hasRole('agent'))
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
                  <table class="table table-bordered table-striped" id="society-list">
                    <thead>
                        <tr>
                          <th>Society ID</th>
                          <th>Name</th>
                          <th>Society Map</th>
                          <th>Society PDF Map</th>
                          <th>Number of Plots</th>
                          <th>Priority</th>
                          <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($societies as $society)
                          @php
                            $societyID = $society->society->id;
                          @endphp
                            @if(!empty($society->society))
                                @php
                                  $mapObject = $society->society->society_map->where('type',1)->first();
                                @endphp
                                <tr>
                                    <td><a target="_blank" href='<?php echo url("partner/block/$societyID") ?>'>{{  $society->society->society_id ?? "N/A" }}</a></td>
                                    <td>{{  $society->society->name ?? "N/A" }}</td>
                                    @if($mapObject != NULL)
                                    <td><a target="_blank" href="{{ $mapObject->image_name_url }}">Click to view Map</a></td>
                                    @else
                                     <td><a target="_blank" href="javascript::void();">N/A</a></td>
                                    @endif
                                    @if(!empty($society->society_pdf_map_url))
                                    <td><a target="_blank" href="{{ $society->society_pdf_map_url }}">Click to view Map</a></td>
                                    @else
                                     <td><a target="_blank" href="javascript::void();">N/A</a></td>
                                    @endif
                                    <td>{{  $society->society->number_of_plots ?? "N/A" }}</td>
                                    <td>{{  $society->society->priority ?? "N/A" }}</td>
                                    <td>{{  $society->society->location ?? "N/A" }}</td>
                                    <td>
                                      <a href='<?php echo url("partner/block/$societyID") ?>' class="btn btn-primary"><i class="fa fa-list"></i>&nbsp;Blocks</a>
                                    </td>
                                </tr>
                            @endif
                        @empty
                          <tr><td colspan="6">No Society Allocated !!!</td> </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                          <th>Society ID</th>
                          <th>Name</th>
                          <th>Society Map</th>
                          <th>Society PDF Map</th>
                          <th>Number of Plots</th>
                          <th>Priority</th>
                          <th>Location</th>
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
  @else
    <div class="content-header  navbar-white">
     <h2 class="text-center" style="padding:100px;">You have no permission for this section !!!</h2>
  @endif
@stop
@section('script')
 @parent
<script>

</script>
@endsection