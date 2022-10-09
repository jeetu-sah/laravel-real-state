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
           	 <a href="{{ url('admin/save_countries_cities') }}" data-toggle="tooltip" title="Add Countries/Cities" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-plus"></i> 
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
              <div class="card-header">
                <h5 class="m-0">Countries &amp; Cities</h5>
              </div>
                <div class="card-body">
                  @if(Session::has('msg'))
                  {!!  Session::get("msg") !!}
                  @endif
                  <table class="table table-bordered table-striped" id="laravel_datatable">
                    <thead>
                        <tr>
                          <th>ID</th>
                          <th>Image</th>
                          <th>Country Name</th>
                          <th>Country/City Name</th>
                          <th>Action</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                      @forelse($country_city as $countrycity)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <th>
                          @if(!empty($countrycity->image_url))
                           <img src='{{ $countrycity->image_url }}'  style="height:40px;" />
                          @else
                           <img src="{{ url('public/no_image.jpg') }}"  style="height:40px;" />
                          @endif
                         
                          </th>
                          <td>{{ $countrycity->country_name ?? "N/A" }}</td>
                          <td>{{ $countrycity->city_name }}</td>
                          <td>   
                          <a href='{{ url("admin/remove_countries_cities/$countrycity->id") }}' data-toggle="tooltip" title="Remove Record"  onclick=" return confirm('Are you sure want to remove this record !!!')" class="btn btn-danger " style="margin-right: 5px;">
                    <i class="fas fa-trash"></i> 
                  </a>&nbsp;
                  <a href='{{ url("admin/edit_countries_cities/$countrycity->id") }}' data-toggle="tooltip" title="Edit Record" class="btn btn-primary " style="margin-right: 5px;">
                    <i class="fas fa-edit"></i> 
                  </a>  
                  </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="4">No record found !!!</td>
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