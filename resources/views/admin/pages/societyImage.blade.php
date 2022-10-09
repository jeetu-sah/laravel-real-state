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
                <h5 class="m-0">Society Images</h5>
              </div>
               <div class="row">
                <div class="col-lg-6">
                <form action="{{ route('admin.uploadSocietyImage') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="societyID" name="societyID" value="<?php if(!empty($societyID))echo $societyID; ?>" />
                	<div class="card-body">
                  <input type="file" class="form-control" placeholder="Society Photos" name="spcity_photos[]" multiple="multiple" />
                  
                   <div class="form-group" style="margin-top:15px;">
                    <button type="submit" name="submit" class="btn btn-primary">Save Images</button>
                    </div>
                  </div>
                </form>  
                </div>
               </div>
              
                <div class="card-body">
                  @if(Session::has('msg'))
                    {!!  Session::get("msg") !!}
                  @endif
                @forelse($societyImage as $sImage)
                	
                   <div class="card col-sm-4" style="padding:5px;">
                  	<img class="card-img-top" src="<?php if(!empty($sImage->image_name_url)) echo $sImage->image_name_url;?>" alt="Card image cap">
                      <div class="card-body">
                        <a href="<?php echo url("removeSocietyImage/$sImage->id")?>" class="btn btn-danger">Delete </a>
                      </div>
                </div>
                @empty
               	   <div class="card">
                      <div class="card-body">
                        <p class="card-text">No Image available !!!</p>
                      </div>
                   </div>
                @endforelse
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