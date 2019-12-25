<!-- Footer -->
<footer class="footer">
  <div class="container">
     <div class="row">
         <div class="col-md-4">
          <div class="about_info">
              <h3>About our platform</h3>
              <p>Lorem Ipsum est un générateur de faux textes aléatoires. Vous choisissez le nombre de paragraphes, de mots ou de listes. Vous obtenez alors un texte aléatoire que vous pourrez ensuite utiliser librement dans vos maquettes. Lorem Ipsum est un générateur de faux textes aléatoires. Vous choisissez le nombre de paragraphes, listes. obtenez alors un texte aléatoire que vous pourrez ensuite utiliser librement dans vos maquettes.</p>   
          </div>
         </div>
         <div class="col-md-4">
          <div class="shortLink">
              <h3>Short links</h3>
              <ul>
                  <li><a href=""><i class="fa fa-share" aria-hidden="true"></i> contact</a></li>
                  <li><a href=""><i class="fa fa-share" aria-hidden="true"></i> available agent on map</a></li>
              </ul> 
              <div class="social_sprite">
                  <a class="facebook" href=""></a>
                  <a class="google" href=""></a>
                  <a class="twitter" href=""></a>
                  <a class="instagram" href=""></a>
              </div>
          </div>
         </div>
         <div class="col-md-4">
          <div class="newsletter">
              <h3>Newsletter</h3>
              <p>Sign up for our newsletter and be informed of all the news in preview!</p>   
              <div class="newsletter_box">
                  <input type="text" class="form-control" placeholder="Your Email Here"/>
                  <span><i class="fa fa-envelope"></i></span>
                  <input type="button" class="btn_submit" value="Submit" />
              </div>
          </div>
         </div>
      </div>
      <div class="copyright text-center">
          <p>Copyright © 2019 - Alright reserved by <b>OnTimeBee</b>. Design By: <b>CMO Agency</b></p>
      </div>
  </div>
</footer>

<script> var app_base_url = "{{url('/')}}"; </script>

<script src="{{asset('js/jquery.toast.js')}}"></script>
<script src="{{asset('js/form-validate.js')}}"></script>
<script src="{{asset('js/jquery.validate.js')}}"></script>
 <script src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(document).find('.multi_select').select2({
      placeholder: "Select Options",
    });
  });
  $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
    if (!$(this).next().hasClass('show')) {
      $(this).parents('.dropdown-menu').first().find('.show').removeClass('show');
    }
    var $subMenu = $(this).next('.dropdown-menu');
    $subMenu.toggleClass('show');
    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
      $('.dropdown-submenu .show').removeClass('show');
    });
    return false;
  });
</script>

</body>
</html>