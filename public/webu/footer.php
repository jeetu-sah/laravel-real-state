<footer class="section-footer footer-sec py-3 text-white">
  <div class="container">
    <section class="footer-top padding-top">
      <div class="row">
        <aside class="col-sm-12 col-md-12 col-12">
          <ul class="list-unstyled list-footer-inline">
              <li> <a href="#"> Terms of Uses </a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li> <a href="#">Contact</a></li>
            <li> <a href="#"> Offers </a></li>
          </ul>
        </aside>
      </div> <!-- row.// -->
      <br> 
    </section>
    <section class="footer-bottom border-top-white">
        <div class="row">
      <div class="col-sm-4"> 
        <div class="btn-group white">
                <a title="Facebook" target="_blank" href="#"><i class="fa fa-facebook  fa-fw"></i></a>
                <a title="Instagram" target="_blank" href="#"><i class="fa fa-instagram"></i></a>
                <a title="Twitter" target="_blank" href="#"><i class="fa fa-twitter"></i></a>
            </div>
      </div>
      <div class="col-sm-8">
        <p class="text-md-right text-white-50">Powered by <a href="#">webtricks4u.com</a> Copyright © <a href="#" class="text-white-50"> 2020 CCTV. All Rights Reserved</a>
        </p>
      </div>
      </div>
    </section> <!-- //footer-top -->
  </div><!-- //container -->
</footer>
<a href="#" id="return-to-top"><i class="fa fa-arrow-up"></i></a>

  <!-- Bootstrap core JavaScript -->
  <script src="assets/js/jquery-3.4.1.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="https://www.nextonicayurveda.com/assets/js/slick-carousel.js"></script>

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
  $('.multi-banner').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2900,
      arrows: true,
      dots: false,
      pauseOnHover: false,
      responsive: [{
          breakpoint: 868,
          settings: {
              slidesToShow: 3
          }
      }, {
          breakpoint: 520,
          settings: {
              slidesToShow: 1
          }
      }]
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