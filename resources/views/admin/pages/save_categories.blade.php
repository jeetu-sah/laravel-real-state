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
           	 <a href="{{ url('admin/categories') }}" data-toggle="tooltip" title="category List" class="btn btn-primary float-right" style="margin-right: 5px;">
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
          @if(Session::has('msg'))
            {!!  Session::get("msg") !!}
          @endif
            <div class="card card-primary card-outline">
              <div class="col-sm-8 offset-lg-2">
              <div class="card-header">
                <h5 class="m-0">Categories</h5>
              </div>
                <div class="card-body">
                <form method="POST" action="{{ route('admin.save_category') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Choose Category  </label>
                        <input type="file" class="form-control" placeholder="Category" name="image" /> 
                    </div>
                    <div class="form-group">
                    <label>Select Category  </label>
                        <select class="form-control select2" style="width: 100%;" name="parent_category">
                         <option value="0">Select Category</option>
                            @forelse($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @empty
                              	<option value="0">Select Category</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                    <label>Category Name </label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Category" name="category" />
                    </div>
                    </div>
                    <div class="form-group">
                    <label>Service Average Charge</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="service_average_price" placeholder="Service average Price" />
                    </div>
                    </div>
                     <div class="form-group">
                    <label>Description </label>
                        <textarea name="description" id="meta_tag" class="form-control" placeholder="Description" rows="5"></textarea>
                    </div>
                     <div class="form-group">
                    <label>Meta Tag </label>
                        <textarea name="meta_tag" id="meta_tag" class="form-control" placeholder="Meta Tag" rows="5"></textarea>
                    </div>
                     <div class="form-group">
                    <label>Meta Description </label>
                        <textarea name="meta_decs" id="meta_decs" class="form-control" placeholder="Meta Description" rows="5"></textarea>
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