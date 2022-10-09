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
              <div class="card-header">
                <h5 class="m-0">Allocate Society</h5>
              </div>
                <div class="card-body">
                  <table class="table table-bordered table-striped" id="user-table">
                    <thead>
                        <tr>
                          <th>SN</th>
                          <th>User ID</th>
                          <th>Name</th>
                          <th>Mobile</th>
                          <th>Email</th>
                        </tr>
                    </thead>
                    <tfoot>
                      <tr>
                          <th>SN</th>
                          <th>User ID</th>
                          <th>Name</th>
                          <th>Mobile</th>
                          <th>Email</th>
                        </tr>
                  </tfoot>
                    <tbody>
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
@section('script')
 @parent
<script>
$(document).ready(function(e) {
  /*allocate or deallocate society to partner*/
  $(document).on('click','.allocateSociety',function(){
    var societyID = $("#societyID").val();
    var userID = $(this).val();
    if($(this).is(':checked')){
      $(this).prop('checked',true);
      $(".select_checkbox_permission").prop('checked',true);
        var action = "allocate";
    }
    else{
    $(this).prop('checked',false);
        var action = "deallocate";
      $(".select_checkbox_permission").prop('checked',false);
    } 
    $.ajax({
      url:"{{ route('admin.allocate_deallocate_society_to_partner') }}",
      type: "GET",
      data: {userID:userID,societyID:societyID,action:action},
      success: function (data) {
        alert(data);
      },
      error: function(xhr, error){
        //$("#otp_result_response").html("<div class='notice notice-danger notice'><strong>Wrong </strong> Something went wrong , please try again  !!! </div>");
        //$("#otp_div").show();
      },
      complete: function(){
        //$('#send_otp_btn').html('Submit').attr('disabled' , false);
      }
    }); 
});

  /*End*/

  $('#user-table').DataTable({
    "processing": true,
	  "serverSide": true,
    "sScrollX": "100%",
    "sScrollXInner": "110%",
    "bScrollCollapse": true,
    "ajax":{
        "url": "{{ route('admin.usersList') }}",
        "dataType": "json",
        "type": "GET",
        "data":function(d){
            d.societyID = $('#societyID').val();
        },
        },
    "columns": [
        { data:'sn'},
        { data:'userid'},
        { data:'name'},
	      { data:'mobile'},
        { data:'email' },
    ],
    'columnDefs': [ {
      'targets': [0,1], /* column index */
      'orderable': false, /* true or false */
    }]	  
  }); 

});


</script>
@endsection