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
            <div class="card">
              <div class="card-body">
                <input type="hidden" name="societyID" id="societyID" value="{{ $societyDetails->id }}" />
                <h6 class="card-title"><strong>Society Details</strong></h6>
                    <h6 class="card-text">{{ $societyDetails->name }}.</h6>
                    <h6 class="card-text">{{ $societyDetails->location ?? "N/A" }}.</h6>
                    <h6 class="card-text">{{ $societyDetails->number_of_plots ?? "" }}.</h6>
                    <a href="{{ url('admin/society') }}" class="btn btn-primary">Back</a>
                  </div>
                </div>
            </div>
          </div>
        </div>
    </div>
    @include('admin.pages.component.society_nav')
    <!-- Main content -->
      
    <div class="content header_margin">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="col-sm-8 offset-lg-2">
              <div class="card-header">
                <h5 class="m-0">Edit Plots</h5>
              </div>
                <div class="card-body">
                  @if(Session::has('msg'))
                  {!!  Session::get("msg") !!}
                  @endif
                    @if ($errors->any())
                      @foreach ($errors->all() as $error)
                          <div class="notice notice-danger notice">
                                    {{  $error }}
                                </div>
                      @endforeach
                    @endif
                <form method="POST" action="{{ route('admin.plots.editPlot') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="society_id" id="society_id" value="{{ $societyDetails->id ?? 0 }}" readonly="readonly" />
                <input type="hidden" name="plot_id" id="plot_id" value="{{ $plotDetail->id ?? 0 }}" readonly="readonly" />
                <div class="form-group">
                 <label>Title <span class="text-danger">*</span> </label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Title" name="title" value="{{ $plotDetail->title ?? "" }}" />
                   </div>
                </div>
                <div class="form-group">
                 <label>Plot Size By GAJ<span class="text-danger">*</span> </label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rooms sizze by gaj" name="size_by_gaj" value="{{ $plotDetail->plot_size_by_gaj ?? "" }}" />
                  </div>
                </div>
                <div class="form-group">
                 <label>Number of plots</label>
                  <div class="input-group">
                    <input type="number" class="form-control" placeholder="Number of plots" name="number_of_plots" id="number_of_plots" value="{{ $plotDetail->number_of_plot ?? "" }}" />
                   </div>
                </div>
                <div class="form-group">
                    <label>Priority <span class="text-danger">*</span> </label>
                    <div class="input-group">
                    <input type="number" class="form-control" placeholder="Priority" name="priority" value="{{ $plotDetail->priority ?? "" }}" />
                    </div>
                    </div>     
                    <div class="form-group">
                    <div class="input-group">
                        <button type="submit" name="save_category" class="btn btn-success">Save </button>
                    </div>
                    </div>
                </form>
              </div>
              </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@stop