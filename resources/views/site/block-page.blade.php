@extends('layouts.site.master')
@section('content')
<section>
      <div class="ct-site--map">
        <div class="container">
            <ul id="breadcrumbs" class="breadcrumbs">
              <li class="item-home">
                <a class="bread-link bread-home" href="#" title="Homepage" data-abc="true">Homepage</a>
              </li>
              <li class="separator separator-home"> 
              </li>
              <li class="item-current item-1005"><strong class="bread-current bread-1005"> Block Page</strong>
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
                            <h2 class="pt-3 pb-4 text-center font-bold font-up danger-text">Block Page</h2>
                        </div>
                        <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                    <table class="table table-bordered red-border text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Block Name</th>
                                <th>Plot size by gaj</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td><a href="#">Click here</a></td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td><a href="#">Click here</a></td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td><a href="#">Click here</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
  </div>
    </div>
</section>
@stop
@section('script')
 @parent
 
@endsection