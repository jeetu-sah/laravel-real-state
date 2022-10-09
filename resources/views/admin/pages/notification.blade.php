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
              <li class="breadcrumb-item active">All Notification</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <div class="content header_margin">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                  <div class="card">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                  <i class="ion ion-clipboard mr-1"></i>
                  All Notification
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <ul class="todo-list ui-sortable" data-widget="todo-list">
               	  @forelse($allNotifications as $notification)
                  	@php
                      $msg = $url = NULL;
                      $decodeMsg = json_decode($notification->data);
                      $url = !empty($decodeMsg->url) ? $decodeMsg->url : NULL; 
                      $msg = !empty($decodeMsg->msg) ? $decodeMsg->msg : NULL; 
                    @endphp
                  <li>
                   <a href='{{$url ?? "N/A" }}'> 
                    <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <span class="text">{{ $msg ?? "N/A" }}</span>
                    <!-- Emphasis label -->
                    <small class="badge badge-danger"><i class="far fa-clock"></i>
                       {{ \Carbon\Carbon::parse($notification->created_at)->format(config('app.date_format')) ?? "N/A" }}
                    </small>
                    <!-- General tools such as edit or delete-->
                     </a>
                  </li>
                  @empty
                   <li>
                     No Notification available !!!
                  </li>
                  @endforelse
                </ul>
              </div>
              <!-- /.card-body -->
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