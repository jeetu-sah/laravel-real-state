<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="google-site-verification" content="CmMBFJT8uNpE0y6cG9S3tNvnRd-UKN9WUKXxDPrVxVs" />
<meta name="keywords" content="theam" >
<meta name="description" content="theam" >
<title>{{ $title ?? "Lakhmanis" }}</title>
  <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="{{ asset('public/lakhmani_web/assets/css/bootstrap.min.css?rnd=1.0') }}">
  <!-- Custom styles for this template -->
  <link href="{{ asset('public/lakhmani_web/assets/css/animate.min.css?rnd=1.0') }}" rel="stylesheet">
  <link href="{{ asset('public/lakhmani_web/assets/css/style.css?rnd=1.3') }} " rel="stylesheet">
  <link href="{{ asset('public/lakhmani_web/assets/css/lightbox.css') }} " rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Arsenal" />
</head>
<body>

<div class="sidebar-overlay"></div>
  <!-- Navigation -->
  <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-8"></div>
                    <div class="col-md-6 col-sm-8">
                        <div class="header-bar-inner">
                            <div class="header-left">
                                <ul>
                                    <li><i class="fa fa-phone"></i> +91-8318519393 </li>
                                    <li><i class="fa fa-envelope"></i><a href="#" class="text-white">info@lakhmanis.in</a></li>
                                 
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="header-top-right">
                            <div class="header-right-div">
                                <div class="soical-profile">
                                    <ul>
                                        <li><a href='{{ url('societies') }}' style=""><span class="blink text-white">Plot Availability</span></a></li>
                                        <li><a class="text-white" href="#"><i class="fa fa-facebook"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark-header topbarhead">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
          <img src="{{ asset('public/lakhmani_web/assets/images/logo.png') }}" class="img-fluid" />
        </a>
      <button class="m-bar d-sm-mobile" id="sidebarCollapse"><span class="fa fa-bars"></span></button>
      <button class="navbar-toggler d-none d-sm-block" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="fa fa-bars"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item {{ Request::path() == '/' ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/') }}">Home
            </a>
          </li>
          <li class="nav-item {{ Request::path() == 'gallery' ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/gallery') }}">Gallery
            </a>
          </li>
          <li class="nav-item {{ Request::path() == 'about' ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/about') }}">About Us
            </a>
          </li>
          <li class="nav-item {{ Request::path() == 'admin-login' ? 'active' : '' }}">
            <a target="_blank" class="btncontact nav-link" href="{{ url('/admin-login') }}">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="wrapper">
      <div id="sidebar-form">
            <div id="dismiss">
              <i class="fa fa-remove"></i>
            </div>
            <div class="card card-signin">
              <div class="card-body p-0">
                <h5 class="card-title">Lakhmanis</h5>
                <!--Accordion wrapper-->
                <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">
          <div id="accordian">
              <ul>
                  <li class="active">
                      <ul>
                          <!-- <li class="">
                              <a href="#"> Company</a>
                                  <ul style="display: none;">
                                  <li><a href="#">Team</a></li>
                                  <li><a href="#">Blog</a></li>
                              </ul>
                          </li> -->
                          <li><a href="{{ url('/') }}">Home</a></li>
                          <li><a href="{{ url('about') }}"> About</a></li>
                          <li><a href="{{ url('gallery') }}"> Gallery</a></li>
                          <!-- <li><a href="#">Solutions</a></li> -->
                          <li><a href="{{ url('contact') }}"> contact</a></li>
                          <li><a class="loginM" href="#">Login</a></li>
                      </ul>
                  </li>
              </ul>
          </div>
                </div>
                <!-- Accordion wrapper -->
              </div>
            </div>
      </div>
</div>
 <style>
     .loginM{background: #423f3f;
    margin: 0 20px;
    border-radius: 30px;
    text-align: center;
    color: #fff!important;
    font-size: 18px!important;}
 </style>
  <!--  header end -->
@yield('content')


{{-------Footer section- start--------}}
<footer>
    
<div class="tr-footer py-5 section-bg-white">
            <div class="footer-top section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="footer-widget">
                                <h3>VISIT OUR FARM</h3>
                                <div class="border-h3"></div>
                                <ul class="global-list">
                                    <div class="">
                                      <div class="font-2 float-left"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                                      <p class="location">Indra Nagar Kanpur, UP, India
                                      </p>
                                    </div>
                                    <div class="">
                                      <div class="font-2 float-left"><i class="fa fa-phone" aria-hidden="true"></i></div>
                                      <p class="location">+91-8318519393
                                      </p>
                                  </div>
                                  <div class="">
                                      <div class="font-2 float-left"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                                      <p class="location">info@lakhmanis.in
                                      </p>
                                  </div>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6 col-sm-12 col-md-4 col-lg-4">
                            <div class="footer-widget">
                                <h3>OUR Link</h3>
                                <div class="border-h3"></div>
                                <ul class="global-list">
                                    <li><a class="text-muted" title="" href="{{ url('about') }}">About</a>
                                    </li>
                                    <li><a class="text-muted" title="" href="{{ url('contact') }}">Contact</a>
                                    </li>
                                    <li><a class="text-muted" title="" href="#">Privacy policy</a>
                                    </li>
                                    <li><a class="text-muted" target="_blank" title="" href="{{ url('admin-login') }}">Login</a>
                                    </li>
                                </ul>
                            </div><!-- /.footer-widget -->
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="footer-widget">
                                <h3>Follow Us</h3>
                                <div class="border-h3"></div>
                                <div class="footer-social">
                                    <ul class="global-list">
                                        <li><a target="_blank" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li><a target="_blank" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li><a target="_blank" href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                        <li><a target="_blank" href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.footer-top -->
        </div>
        <div class="section-bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-12"> 
        <p class="text-white-50">Copyright © 2018 - 2020 <a target="_blank" href="#" style="color:white;">Jswebsolutions.in.</a> All Rights reserved</p>
      </div>
    </div> 
    </div>
</div>

</footer>
<a href="#" id="return-to-top"><i class="fa fa-arrow-up"></i></a>
  <!-- Bootstrap core JavaScript -->
  <script src="{{ asset('public/lakhmani_web/assets/js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('public/lakhmani_web/assets/js/bootstrap.min.js?rnd=1.0') }}"></script>
  <script src="{{ asset('public/lakhmani_web/assets/js/main.js?rnd=1.0') }} "></script>
  <script src="{{ asset('public/lakhmani_web/assets/js/lightbox-plus-jquery.min.js') }} "></script>
 @section('script')
 @show 
</body>
<script>
$(document).ready(function(e) {
    $(window).scroll(function(e) {
        var positiontop = $(document).scrollTop();
    //console.log(positiontop);
    if((positiontop > 10) || (positiontop > 10)){
      $('.topbarhead').addClass('animated fadeInDown csschange fixed-top');
    } else {
      $('.topbarhead').removeClass('animated fadeInDown csschange fixed-top');
  }
    });
});
$(document).ready(function(){
     $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#return-to-top').fadeIn();
            } else {
                $('#return-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#return-to-top').click(function () {
            $('#return-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        $('#return-to-top').tooltip('show');
});
</script>

</html>