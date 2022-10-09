@extends('layouts.site.master')
@section('content')
<!--  wrapper  -->
  <div id="wrapper">
                <!-- content-->
                <div class="content">
                    <!--  section  -->
                    <section class="color3-bg1 parallax-section">
                        <div class="city-bg"></div>
                        <div class="cloud-anim cloud-anim-bottom x1"><i class="fal fa-cloud"></i></div>
                        <div class="cloud-anim cloud-anim-top x2"><i class="fal fa-cloud"></i></div>
                        <div class="overlay op1 color3-bg1"></div>
                        <div class="container">
                            <div class="error-wrap">
                                <h2>404</h2>
                                <p>We're sorry, but the Page you were looking for, couldn't be found.</p>
                                <div class="clearfix"></div>
                                <form action="#">
                                    <input name="se" id="se" type="text" class="search" placeholder="Search.." value="">
                                    <button class="search-submit color-bg" id="submit_btn"><i class="fal fa-search"></i> </button>
                                </form>
                                <div class="clearfix"></div>
                                <p>Or</p>
                                <a href="#" class="btn color2-bg flat-btn">Back to Home Page<i class="fal fa-home"></i></a>
                            </div>
                        </div>
                    </section>
                    <!--  section  end-->
                </div>
                <!-- content end-->
            </div>
<!--wrapper end -->
@stop