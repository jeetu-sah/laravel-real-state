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
           	 <a href="{{ url('admin/countries_cities') }}" data-toggle="tooltip" title="category List" class="btn btn-primary float-right" style="margin-right: 5px;">
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
                <h5 class="m-0">Edit Countries , Satate & Cities</h5>
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
                <form method="POST" action="{{ route('admin.update_countries_cities') }}" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                    <input type="hidden" name="edit_id" value="{{$countryCity->id}}">
                    <input type="hidden" name="state" class="hidden_state" value="{{$countryCity->state ?? 0}}">
                    <label>Select Country  </label>
                        <select class="form-control select2" style="width:100%;" name="country" id="editcountry" data-action="editCountry">
                         <option value="0">Select Country</option>
                            @forelse($countries as $country)
                                <option value="{{ $country->id }}" <?php if($country->id == $countryCity->parent_id){ echo "selected"; } ?>>{{ $country->name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                    <label>Select State  </label>
                    
                    <select class="form-control select2" style="width: 100%;" name="state" id="state">
                         <option value="0">First Select Country </option>
                        </select>
                    </div>
                    <div class="form-group">
                    &nbsp;
                    <label>Country / City Name </label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Country/City Name" name="country_city_name" value="{{$countryCity->name}}" required />
                    </div>
                    </div>
                    <div class="form-group">
                    <label>Priority </label>
                    <div class="input-group">
                        <input type="number" class="form-control" placeholder="Priority" name="priority" 
                        value="{{$countryCity->priority}}" required />
                    </div>
                    </div>
                    <div class="form-group">
                    <label>Image </label>
                    <div class="input-group">
                        <input type="file" class="form-control"  name="image"  />
                    </div>
                    @if($image != NULL)
                    <div class="form-group">
                      <img src="{{$image->image_name_url}}" height="100" width="100">
                    </div>
                    @endif
                    </div>
                     <div class="form-group">
                        <label>Description </label>
                            <textarea name="description" id="meta_tag" class="form-control" placeholder="Description" rows="5">{{$countryCity->description}}</textarea>
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
@section('script')
 @parent
<script src="{{ url('public/SiteJs/adminCommon.js') }}"></script>
<script>
var findStateUrl = "{{ route('common.find_states') }}";
</script>
@endsection
