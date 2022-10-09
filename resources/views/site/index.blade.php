@extends('layouts.site.master')
@section('content')
<section class="top-header-bottom">
  <div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
         <div id="demo" class="carousel slider-index slide" data-ride="carousel">
              <ul class="carousel-indicators">
                <li data-target="#demo" data-slide-to="0" class=""></li>
                <li data-target="#demo" data-slide-to="1" class=""></li>
                <li data-target="#demo" data-slide-to="2" class=""></li>
                <li data-target="#demo" data-slide-to="3" class="active"></li>                 
              </ul>
              <div class="wrapper-slider">
               <div class="carousel-inner">
                      <div class="carousel-item active">
                        <div class="overlay"></div>
                            <a title="" href="">
                            <img alt="" class="image img-fluid" src="{{ asset('public/lakhmani_web/assets/images/banner.jpg') }}"></a>
                        </div>
                        <div class="carousel-item">
                            <div class="overlay"></div>
                            <a title="" href=""><img alt="" class="image img-fluid" src="{{ asset('public/lakhmani_web/assets/images/banner.jpg') }}"></a>
                        </div>
                      </div>
              </div>
              <!-- Left and right controls -->
              <a class="carousel-control-prev" href="#demo" data-slide="prev">
                <span class="fa fa-angle-left"></span>
              </a>
              <a class="carousel-control-next" href="#demo" data-slide="next">
                <span class="fa fa-angle-right"></span>
              </a>
          </div>
    </div>
</div>
</section>
<div class="aboutpadding athead">
		<div class="container">
			<div class="stal_header">
				<h2>About <span> Us</span></h2>
				<p><span><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
			</div>
			<div class="stal_skills_grids row py-3">
				<div class="col-md-7 agileinfo_about_left">
					<p class="mb-3">INDRA NAGAR have had the vision of establishing residential housing projects at affordable prices in the rural areas, places where you were born and brought up. It is a dismal happening that you have to eventually leave your childhood home and move to the cities in search of a better job opportunities, better education, better medical facilities and overall a better life.</p>
					<div class="nav-item mb-3">
					    <a class="p-2 btncontact" href="{{ url('about') }}">More Details</a>
					</div>
				</div>
				<div class="col-md-5 agileinfo_about_right">
					<img src="{{ asset('public/lakhmani_web/assets/images/about.gif') }}" alt=" " class="img-fluid">
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
<section class="section section-lg bg-gray-lighter novi-background bg-cover">
    <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="post-content-body my-5">
                <div class="widget-title">
                    <h3 class="title">RUNNING PROJECTS</h3>
                    <a class="more" href="#">View more</a>
                </div>
                <div class="row">
                    @forelse($societies as $society)
                        @php
                            $societyImage = $society->society_map->where('type',1)->first();
                        @endphp
                        <div class="col-lg-4 marginbot">
                            <div class="entry2">
                                <a href='{{ url("society/$society->id") }}'>
                                    @if(!empty($societyImage->image_name_url))
                                <img src="{{ $societyImage->image_name_url }}" alt="{{ $society->name ?? "Unknown"}}" class="img-fluid">
                                    @else
                                     <img src="{{ asset('public/lakhmani_web/assets/images/2.jpg') }}" alt="Image" class="img-fluid">
                                    @endif
                                </a>
                                <div class="excerpt">
                                <h2>
                                     <a href='{{ url("society/$society->id") }}'>{{ $society->name ?? "Unknown" }}</a>
                                </h2>
                                    <div class="post-meta">
                                            <span class="mr-2">{{ $society->location ?? "Unknown" }} </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                     
                    @endforelse
                </div>
              </div>
          </div>
        </div>
    </div>
</section>
<div class="classic-counter-sec">
        <div class="why-us-sec-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="classic-counter-inner">
                        <span class="classic-counter-sub-title text-white">We provide residential and commercial.</span>
                        <!--<h2 class="classic-counter-title">What we achive in here</h2>-->
                        <div class="classic-counter-box">
                            <div class="classic-counter-icon">
                                <i class="fa fa-area-chart"></i>
                            </div>
                            <div class="classic-counter-text">
                                <h4>Development</h4>
                            </div>
                        </div>
                        <div class="classic-counter-box">
                            <div class="classic-counter-icon">
                                <i class="fa fa-building"></i>
                            </div>
                            <div class="classic-counter-text">
                                <h4>Plotting</h4>
                            </div>
                        </div>
                        <div class="classic-counter-box">
                            <div class="classic-counter-icon">
                                <i class="fa fa-handshake-o"></i>
                            </div>
                            <div class="classic-counter-text">
                                <h4>Support</h4>
                            </div>
                        </div>
                        <div class="classic-counter-box">
                            <div class="classic-counter-icon">
                                <i class="fa fa-home"></i>
                            </div>
                            <div class="classic-counter-text">
                                <h4>Homes</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                   
                </div>
            </div>
        </div>
    </div>

  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Detox Formula Detox Supplement 1</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form>
              <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="" placeholder="Name" class="form-control" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="" placeholder="Last Name" class="form-control" />
                        </div>
                    </div>
              </div>
               <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="Email" name="" placeholder="Email" class="form-control" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="Number" name="" placeholder="Mobile No." class="form-control" />
                        </div>
                    </div>
              </div>
               <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <textarea type="text" rows="2" class="form-control" placeholder="Message"></textarea>
                        </div>
                    </div>
              </div>
              <div class="">
                  <button type="Submit" class="btn weight--semibold login-button btn--green">Submit</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@stop
@section('script')
 @parent
 
@endsection

