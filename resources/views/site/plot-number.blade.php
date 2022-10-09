@extends('layouts.site.master')
@section('content')
<section>
      <div class="ct-site--map">
        <div class="container">
            <ul id="breadcrumbs" class="breadcrumbs">
              <li class="item-home">
                <a class="bread-link bread-home" href="{{ url('/') }}" title="Homepage" data-abc="true">Homepage</a>
              </li>
              </li>
                <a class="bread-link bread-home" href="{{ url('/societies') }}" title="Society List" data-abc="true">Society List</a>
              </li>
              <li class="item-home">
                    <a class="bread-link bread-home" href='{{ url('societies') }}' title="{{ $societyBlocksPlots->blocks->name ?? "N/A"}}" data-abc="true">
                         {{ $societyBlocksPlots->blocks->name ?? "N/A"}}
                    </a>
              </li>
              <li class="separator separator-home"></li>
                <li class="item-current item-1005">
                    <strong class="bread-current bread-1005">{{ $societyBlocksPlots->title ?? "N/A"}}</strong>
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
                            <h2 class="pt-3 pb-4 text-center font-bold font-up danger-text">Plots</h2>
                        </div>
                        <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                    <table class="table table-responsive table-bordered red-border text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Plot Number </th>
                                <th>Plot Area (in Gaj)</th>
                                <th>booking Status</th>
                                <th>Plot Area</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($societyBlocksPlots != NULL)
                                @forelse ($societyBlocksPlots->blockPlotsNumber as $plot)
                                    <tr class="{{ sHelper::tableTrClass($plot->booking_status) }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $plot->plot_number }}</td>
                                        <td>{{ $plot->plot_size_in_gaj }}</td>
                                        <td> 
                                            @if(array_key_exists($plot->booking_status, $bookingStatusArr))
                                            {{  $bookingStatusArr[$plot->booking_status] }}
                                            @else
                                            {{ "N/A" }}
                                            @endif
                                        </td>
                                        <td>{{ $plot->plot_area }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <th scope="row" colspan="4">No Plots available !!!</th>
                                    </tr>
                                @endforelse
                            
                            @else
                                  <tr>
                                        <th scope="row" colspan="4">No Plots available !!!</th>
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