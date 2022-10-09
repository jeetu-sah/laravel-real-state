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
           	 <a href="{{ url('admin/society') }}" data-toggle="tooltip" title="Society List" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-list"></i> 
                  </a>
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
              <div class="col-sm-12">
              <div class="card-header">
                <h5 class="m-0">Add Society</h5>
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
                <form method="POST" action="{{ route('admin.edit_society') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="editid" id="editid" value="{{ $societyDetails->id ?? 0 }}" readonly>
                <div class="form-group">
                 <label>Society ID <span class="text-danger">*</span> </label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Partner ID" name="society_id" value="{{ $societyDetails->society_id ?? 0 }}"  />
                   </div>
                </div>
                <div class="form-group">
                 <label>Society Name <span class="text-danger">*</span> </label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Society Name" name="name" value="{{ $societyDetails->name ?? 0 }}" />
                   </div>
                </div>
                <div class="form-group">
                  <label>Choose Society Map<span class="text-danger">*</span> </label>
                      <input type="file" class="form-control" placeholder="Society Map" name="image" /> 
                </div>
                <div class="form-group">
                  <label>Choose Society PDF Map </label>
                      <input type="file" class="form-control" placeholder="Society PDF Map" name="society_pdf_map"  required /> 
                </div>
                <div class="form-group">
                 <label>Number of plots  </label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Number of plots" name="number_of_plots" value="{{ $societyDetails->number_of_plots ?? 0 }}" />
                  </div>
                </div>
                
                    <div class="form-group">
                    <label>Priority <span class="text-danger">*</span> </label>
                    <div class="input-group">
                    <input type="number" class="form-control" placeholder="Priority" name="priority" value="{{ $societyDetails->priority ?? 0 }}" />
                    </div>
                    </div>
                     <div class="form-group">
                        <label>Location </label>
                        <textarea name="location" id="location" class="form-control" placeholder="Location" rows="5">{{ $societyDetails->location ?? "" }}</textarea>
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