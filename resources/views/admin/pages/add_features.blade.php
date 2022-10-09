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
           	 <a href="{{ url('admin/features_list') }}" data-toggle="tooltip" title="category List" class="btn btn-primary float-right" style="margin-right: 5px;">
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
              <div class="col-sm-8 offset-lg-2">
              <div class="card-header">
                <h5 class="m-0">Features</h5>
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
                <form method="POST" action="{{ route('admin.save_features') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Choose Icon  </label>
                        <input type="file" class="form-control" placeholder="Category" name="image" /> 
                    </div>
                    <div class="form-group">
                    <label>Paste Icon Code <span class="text-info"><a target="_blank" href="https://fontawesome.com/icons?m=free">Click Here to find Icon code </a></span></label>
                    <p class="text-danger" style="font-size:12px;">
                      Paste only Class name Ex: fal fa-wifi
                    </p>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Icon Code" name="icon_code" />
                    </div>
                    </div>
                    <div class="form-group">
                    <label>Select Category  </label>
                        <select class="form-control select2" style="width: 100%;" name="main_service">
                         <option value="0">Select Category</option>
                            @forelse($main_services as $services)
                                <option value="{{ $services->id }}">{{ $services->name }}</option>
                            @empty
                              	<option value="0">Select Category</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                    <label>Category Name </label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Features Name" name="feature_name" />
                    </div>
                    </div>
                    <div class="form-group">
                    <label>Priority </label>
                    <div class="input-group">
                        <input type="number" class="form-control" placeholder="Priority" name="priority" value="@if(!empty($priority))){{$priority}}@endif" />
                    </div>
                    </div>
                     <div class="form-group">
                        <label>Description </label>
                            <textarea name="description" id="meta_tag" class="form-control" placeholder="Description" rows="5"></textarea>
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