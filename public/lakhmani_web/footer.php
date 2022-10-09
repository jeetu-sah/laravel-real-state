<footer>
    
<div class="tr-footer py-5 section-bg-white">
            <div class="footer-top section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-3 col-lg-3">
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
                        <div class="col-6 col-sm-12 col-md-3 col-lg-3">
                            <div class="footer-widget">
                                <h3>OUR Link</h3>
                                <div class="border-h3"></div>
                                <ul class="global-list">
                                    <li><a class="text-muted" title="" href="#">About</a>
                                    </li>
                                    <li><a class="text-muted" title="" href="#">Contact</a>
                                    </li>
                                    <li><a class="text-muted" title="" href="#">Privacy policy</a>
                                    </li>
                                </ul>
                            </div><!-- /.footer-widget -->
                        </div>
                        <div class="col-6 col-sm-12 col-md-3 col-lg-3">
                            <div class="footer-widget">
                                <h3>QUICK LINKS</h3>
                                <div class="border-h3"></div>
                                <ul class="global-list">
                                     <li><a class="text-muted" title="" href="#">Project</a>
                                    </li>
                                    <li><a class="text-muted" title="" href="#">Project</a>
                                    </li>
                                    <li><a class="text-muted" title="" href="#">Project</a>
                                    </li>
                
                                </ul>
                            </div><!-- /.footer-widget -->
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3">
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
  <script src="assets/js/jquery-3.4.1.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/main.js"></script>

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