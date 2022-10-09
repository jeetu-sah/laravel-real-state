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
                    <table class="table table-bordered red-border text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Society Name</th>
                                <th>Society Address</th>
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