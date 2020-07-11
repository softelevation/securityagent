<!-- Footer -->
<style>
#landContainer{
	background: #333;
    color: #fff;
    display: none;
    font-size: 15px !important;
    left: 0;
	bottom: 0;
    position: fixed;
    box-sizing: content-box;
    z-index: 2147483645;
    text-align: center;
    padding: 10px;
    margin: auto;
    width: 100%;
}
#tarteaucitronPersonalize{
	background: #fdde59;
    color: #fff;
    cursor: pointer;
    display: inline-block;
    font-size: 16px;
    padding: 5px 10px;
    text-decoration: none;
    margin-left: 7px;
}
#tarteaucitronCloseAlert{
	background: #fff;
    color: #333;
    font-size: 13px;
    margin-bottom: 3px;
    margin-left: 7px;
    padding: 4px 10px;
}
</style>

<div id="landContainer" style="display: none;">
  <span id="tarteaucitronDisclaimerAlert">{{__('frontend.banner_contant')}}</span>
  <button type="button" id="tarteaucitronPersonalize">✓ OK, accept all</button>
  <button type="button" id="tarteaucitronCloseAlert">Personalize</button>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="about_info">
                    <h3>{{__('frontend.text_25')}}</h3>
                    <p>{{__('frontend.text_26')}}</p>  
					<ul class='contact-us'>
						<li>{{__('frontend.text_153')}}</li>
					</ul>
                </div>
				
            </div>
            <div class="col-md-4">
                <div class="shortLink">
                    <h3>{{__('frontend.text_27')}}</h3>
                    <ul>
                        <li><a href="{{url('/contact-us')}}"><i class="fa fa-share" aria-hidden="true"></i> {{__('frontend.text_28')}}</a></li>
                        <li><a href="{{url('/available-agents')}}"><i class="fa fa-share" aria-hidden="true"></i> {{__('frontend.text_29')}}</a></li>
                    </ul> 
                    <div class="social_sprite">
                        <a class="facebook" href="#"></a>
                        <a class="google" href="#"></a>
                        <a class="twitter" href="#"></a>
                        <a class="instagram" href="#"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="newsletter">
                    <h3>Newsletter</h3>
                    <p>{{__('frontend.text_30')}}</p>   
                    <div class="newsletter_box">
                        <input type="text" class="form-control" placeholder="{{__('frontend.text_31')}}"/>
                        <span><i class="fa fa-envelope"></i></span>
                        <input type="button" class="btn_submit" value="Submit" />
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright text-center">
            <p>Copyright © 2020 - Alright reserved by <b>Be On Time</b>. Design & Develop By <b><a class="" href="https://www.cmo-agency.com/">CMO Agency</a></b></p>
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


<script> var app_base_url = "{{url('/')}}";</script>
<script src="{{asset('js/jquery.toast.js')}}"></script>
<script src="{{asset('js/form-validate.js')}}"></script>
<script src="{{asset('js/jquery.validate.js')}}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('js/custom.js')}}"></script>
</body>
</html>