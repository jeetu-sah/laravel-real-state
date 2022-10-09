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
           	 <a href="{{ url('admin/roles/permission_list') }}" data-toggle="tooltip" title="Permissions List" class="btn btn-primary float-right" style="margin-right: 5px;">
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
               @if($pemisison_detail != NULL)
                 <h5 class="m-0">Edit Permission</h5>
               @else
                 <h5 class="m-0">Add Permission</h5>
               @endif
                
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
                <form method="POST" action="{{ route('admin.roles.save_permission') }}" enctype="multipart/form-data">
                @csrf
                  <input type="hidden" name="edit" id="edit" value="{{ $pemisison_detail->id ?? "" }}" readonly="readonly">
                    <div class="form-group">
                    <label>Permission Name </label>
                    <div class="input-group">
                        @if($pemisison_detail != NULL)
                         <input type="text" class="form-control" placeholder="Permission Name" name="name" value="{{ $pemisison_detail->name ?? "" }}" readonly="readonly" />
                        @else
                         <input type="text" class="form-control" placeholder="Permission Name" name="name" value="{{ old('name') }}" />
                        @endif
                       
                    </div>
                    </div>
                    <div class="form-group">
                    <label>Display Name </label>
                    <div class="input-group">
                       <input type="text" class="form-control" placeholder="Display Name" name="display_name" value="{{ $pemisison_detail->display_name ?? "" }}" />
                    </div>
                    </div>
                     <div class="form-group">
                        <label>Description </label>
                            <textarea name="description" id="meta_tag" class="form-control" placeholder="Description" rows="5">{{$pemisison_detail->description ?? ""}}</textarea>
                    </div>
                    @role('super-admin')
                      <div class="form-group">
                        <div class="input-group">
                            <button type="submit" name="save_category" class="btn btn-success">Save </button>
                        </div>
                      </div>
                    @endrole
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