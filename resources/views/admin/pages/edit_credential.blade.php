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
           	 <a href="{{ url('admin/partner_list') }}" data-toggle="tooltip" title="Users List" class="btn btn-primary float-right" style="margin-right: 5px;">
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
                <h5 class="m-0">Change Users Credentials</h5>
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
               @if(Auth::user()->isAbleTo('change-user-credential'))
                <form method="POST" action="{{ route('admin.change_credential') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                 <label>Login ID <span class="text-danger">*</span> </label>
                  <div class="input-group">
                   <input type="hidden" class="form-control" name="user_id" id="user_id" value="{{ $userDetail->id  ?? ""}}" />
                    <input type="text" class="form-control" placeholder="User ID" name="login_id" id="login_id" value="{{ $userDetail->login_id  ?? ""}}" />
                   </div>
                </div>
                <div class="form-group">
                 <label>Password </label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Password" name="password" id="password" />
                   </div>
                </div>
                    <div class="form-group">
                    <div class="input-group">
                        <button type="submit" name="change_credential" class="btn btn-success">Change Credential </button>
                    </div>
                    </div>
                </form>
               @else
                <h2>You have no permission to change the credential of users !!!</h2>
               @endif
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