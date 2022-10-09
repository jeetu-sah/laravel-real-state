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
              <li class="breadcrumb-item">Dashboard</li>
              <li class="breadcrumb-item active">{{  $societyDetails->name ?? "N/A" }}</li>
              <li class="breadcrumb-item active">{{  $societyBlock->title ?? "N/A" }}</li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
    <!-- /.content-header -->
    <div class="content header_margin">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-body">
                  <h6 class="card-title"><strong>Plot Details Details</strong></h6>
                  <h6 class="card-text">Plots Number : {{ $plotsDetails->plot_number ?? "N/A"}}.</h6>
                  <h6 class="card-text">Plots Value : {{ $plotsDetails->plot_value ?? "N/A" }}.</h6>
                  <h6 class="card-text">{{ $bookingStatus ?? "" }}. </h6>
                  <a href='{{ url("admin/plots/plotsNumber/$plotsDetails->society_plot_id") }}' class="btn btn-primary">Back</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
    <!-- Main content -->
    <div class="content header_margin">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <a href='{{ url("admin/plots/paymentHistory/$plotsDetails->id") }}' 
                  data-toggle="tooltip" 
                  title="Payment History" 
                  class="btn btn-primary float-right" 
                  style="margin-right:5px;">
            <i class="fas fa-list"></i> 
            Payment History
            </a>
         </div>
      </div>
   </div>
</div>
    <div class="content header_margin">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@stop
