@extends('layouts.site.master')
@section('content')
<section>
      <div class="ct-site--map">
        <div class="container">
            <ul id="breadcrumbs" class="breadcrumbs">
              <li class="item-home">
                <a class="bread-link bread-home" href="{{ url('/') }}" title="Homepage" data-abc="true">Homepage</a>
              </li>
              <li class="separator separator-home"> 
              </li>
              <li class="item-current item-1005"><strong class="bread-current bread-1005"> Society List</strong>
              </li>
            </ul>        
        </div>
    </div>
</section>
<section class="top-header-bottom-page">
    <div class="container">
        <div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card my-5 box-shadowNew">
                <div class="card-body">
                    <!-- Grid row -->
                    <div class="row">
                        <!-- Grid column -->
                        <div class="col-md-12">
                            <h2 class="pt-3 pb-4 text-center font-bold font-up danger-text">Society List</h2>
                        </div>
                        <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                    <table class="table table-responsive table-bordered red-border text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Society Name</th>
                                <th>Society Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($societies as $society)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $society->name }}</td>
                                    <td>{{ $society->location }}</td>
                                    <td><a href='{{ url("blocks/$society->slug_name") }}'>Click here</a></td>
                                </tr>
                            @empty 
                                 <tr>
                                    <th scope="row" colspan="4">No Society Available !!!</th>
                                  
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
  </div>
    </div>
</section>
<style>
.top-header-bottom-page{background: #8ec1e11f;}
.box-shadowNew{background: #fff;
    box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
    border-radius: 5px;}
.danger-text {color: #ff3547; }  
.success-text {color: #00C851; }
.table-bordered.red-border, .table-bordered.red-border th, .table-bordered.red-border td {border: 1px solid #ff3547!important;}        
.table.table-bordered th {text-align: center;}
</style>
@stop
@section('script')
 @parent
 
@endsection