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
    <div class="content header_margin">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="col-sm-8 offset-lg-2">
              <div class="card-header">
                <h5 class="m-0">Add Customer</h5>
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
                <form method="POST" action="{{ route('customer.createCustomer') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group" style="display:;">
                 <label>User ID <span class="text-danger">*</span> </label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="User ID" name="partner_id" value="{{ $partnerID ?? 0 }}" readonly />
                   </div>
                </div>
                <div class="form-group">
                 <label>Name <span class="text-danger">*</span> </label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Name" name="name" />
                   </div>
                </div>
                <div class="form-group">
                 <label>Mobile / Contact Number <span class="text-danger">*</span> </label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Mobile / Contact Number" name="mobile" />
                  </div>
                </div>
                <div class="form-group">
                 <label>User ID <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="User ID" name="login_id" id="login_id" value="{{$customerID}}" />
                   </div>
                </div>
                 <div class="form-group">
                 <label>Password</label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Password" name="password" />
                   </div>
                </div>
                <div class="form-group">
                    <label>Select Id Prof Type <span class="text-danger">*</span> </label>
                    <select class="form-control select2" style="width: 100%;" name="proof_type">
                      @forelse ($proofType as $proof)
                        <option value="{{ $proof->id }}">{{ $proof->name }}</option>
                      @empty
                        <option value="0">Select Category</option>
                      @endforelse
                      
                    </select>
                </div>
                <div class="form-group">
                    <label>Id Proof Number <span class="text-danger">*</span> </label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Id Proof Number" name="id_proof_number"  required/>
                    </div>
                </div>
                <div class="form-group">
                  <label>Choose Photo  <span class="text-danger">*</span> </label>
                      <input type="file" class="form-control" placeholder="icon" name="image" required /> 
                </div>
                    <div class="form-group">
                    	<label>Priority <span class="text-danger">*</span> </label>
                        <div class="input-group">
                        <input type="number" class="form-control" placeholder="Priority" name="priority" value="{{ $priority ?? 0 }}" />
                    </div>
                    </div>
                     <div class="form-group">
                        <label>Address </label>
                            <textarea name="address" id="address" class="form-control" placeholder="Address" rows="5"></textarea>
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