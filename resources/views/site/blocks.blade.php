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
                <a class="bread-link bread-home" href="{{ url('/societies') }}" title="Homepage" data-abc="true">Society List</a>
              </li>
              </li>
                <li class="item-current item-1005"><strong class="bread-current bread-1005">{{ $societyBlocks->name ?? "N/A" }}</strong>
                </li>
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
                            <h2 class="pt-3 pb-4 text-center font-bold font-up danger-text">Blocks</h2>
                        </div>
                        <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                    <table class="table table-responsive table-bordered red-border text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Block Name</th>
                                <th>Plot size by gaj</th>
                                <th>Plot Value</th>
                                <th>Number of Plots</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($societyBlocks != NULL)
                                @forelse ($societyBlocks->blocks as $blocks)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $blocks->title ?? "N/A" }}</td>
                                        <td>{{ $blocks->plot_size_by_gaj ?? "N/A" }}</td>
                                        <td>{{ $blocks->plot_value ?? "N/A" }}</td>
                                        <td>{{ $blocks->number_of_plot ?? "N/A" }}</td>
                                        <td><a href='{{ url("plot-number/$blocks->id") }}'>Click here</a></td>
                                    </tr>
                                    
                                @empty
                                    <tr>
                                        <th scope="row" colspan="4">No Blocks available !!!</th>
                                    </tr>
                                @endforelse
                            @else
                                <tr>
                                    <th scope="row" colspan="4">Something went wrong , please try again  !!!</th>
                                </tr>
                            @endif

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