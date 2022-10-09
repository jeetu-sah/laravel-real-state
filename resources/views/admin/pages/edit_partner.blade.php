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
                  Users List
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
                <h5 class="m-0">Edit Partners</h5>
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
                    @if($partner  != NULL)
                    <form method="POST" action="{{ route('admin.edit_partners') }}" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                      <label>Partner ID <span class="text-danger">*</span> </label>
                        <div class="input-group">
                           <input type="hidden" class="form-control" placeholder="Partner ID" name="editid" value="{{ $partner->id }}" readonly />
                          <input type="text" class="form-control" placeholder="Partner ID" name="partner_id" value="{{ $partner->user_id ?? 0 }}" readonly />
                        </div>
                      </div>
                      <div class="form-group">
                      <label>Name <span class="text-danger">*</span> </label>
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Name" name="name"  value="{{ $partner->f_name ?? " "}}"/>
                        </div>
                      </div>
                      <div class="form-group">
                      <label>Mobile / Contact Number <span class="text-danger">*</span> </label>
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Mobile / Contact Number" name="mobile" value="{{ $partner->mobile ?? " "}}"  />
                        </div>
                      </div>
                      <div class="form-group">
                      <label>Email </label>
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Email" name="email" value="{{ $partner->email ?? " "}}" />
                        </div>
                      </div>
                      <div class="form-group">
                 <label>Commission Percentage</label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Commission Percentage" name="commission_percentage" value="{{ $partner->commission ?? 0}}" />
                   </div>
                </div>
                      <div class="form-group">
                          <label>Select Id Prof Type <span class="text-danger">*</span> </label>
                          <select class="form-control select2" style="width: 100%;" name="proof_type">
                            @forelse ($proofType as $proof)
                              <option value="{{ $proof->id }}" <?php if($proof->id == $partner->proof_type_id){ echo "selected"; } ?>>{{ $proof->name }}</option>
                            @empty
                              <option value="0">Select Category</option>
                            @endforelse
                            
                          </select>
                      </div>
                      <div class="form-group">
                          <label>Id Proof Number <span class="text-danger">*</span> </label>
                          <div class="input-group">
                              <input type="text" class="form-control" placeholder="Id Proof Number" name="id_proof_number" value="{{ $partner->id_proof_number ?? " "}}"  required/>
                          </div>
                      </div>
                      <div class="form-group">
                        <label>Choose Photo  <span class="text-danger">*</span> </label>
                            <input type="file" class="form-control" placeholder="icon" name="image" /> 
                      </div>
                          <div class="form-group">
                          <label>Priority <span class="text-danger">*</span> </label>
                          <div class="input-group">
                          <input type="number" class="form-control" placeholder="Priority" name="priority" value="{{ $partner->priority ?? 0 }}" />
                          </div>
                          </div>
                          <div class="form-group">
                              <label>Description </label>
                                  <textarea name="description" id="meta_tag" class="form-control" placeholder="Description" rows="5">{{ $partner->description ?? " " }}</textarea>
                          </div>
                          <div class="form-group">
                          <div class="input-group">
                              <button type="submit" name="save_category" class="btn btn-success">Save </button>
                          </div>
                          </div>
                      </form>
                      @else
                        <h4>No Record Found !!!</h4>
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