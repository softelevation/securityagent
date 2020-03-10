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
  <form id="agent_availabity_form" method="post" action="{{url('agent/set-availability')}}">
    @csrf
    <input id="availability_status" type="hidden" name="availability_status">
    <input type="hidden" name="current_url" value="{{url()->full()}}">
  </form>
  <!-- Process Customer notification -->
  <form id="customer_notification_form" method="post" action="{{url('/process-notification')}}">
    @csrf
    <input id="notification_id" type="hidden" name="notification_id">
    <input id="notification_url" type="hidden" name="notification_url">
  </form>
</footer>

<script> var app_base_url = "{{url('/')}}"; </script>
<script src="{{asset('js/jquery.toast.js')}}"></script>
<script src="{{asset('js/form-validate.js')}}"></script>
<script src="{{asset('js/jquery.validate.js')}}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('js/custom.js')}}"></script>
</body>
</html>