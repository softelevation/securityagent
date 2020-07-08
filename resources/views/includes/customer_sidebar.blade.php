<div class="col-md-3 mb-3"> 
    <div class="Left_tabs_panel border">
        <div class="profile_img">
            @if(isset(Auth::user()->customer_info->image) && Auth::user()->customer_info->image!="")
                <img src="{{asset('profile_images/'.Auth::user()->customer_info->image)}}" class="img-fluid" />
            @else
                <img src="{{asset('assets/images/user_img.jpg')}}" class="img-fluid" />
            @endif
            <h3>{{Auth::user()->email}} <span>{{__('dashboard.customer')}}</span></h3>
        </div>
        <div class="tabs_menu">
            <ul class="nav flex-column sidebar_nav" id="myTab" role="tablist">
                <li class="nav-item">
                    <a href="{{url('operator/profile')}}" class="nav-link"><i class="fa fa-user-edit"></i> {{__('dashboard.profile')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{url('customer/missions')}}" class="nav-link"><i class="fa fa-edit"></i> {{__('dashboard.missions')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{url('customer/billing-details')}}" class="nav-link"><i class="fa fa-file-invoice"></i> &nbsp; {{__('dashboard.billing')}}</a>
                </li>
				<li class="nav-item">
                    <a class="nav-link" href="{{url('customer/message-center')}}"><i class="fa fa-message_center"></i> {{__('dashboard.mission.message_center')}}</a>
                </li>
				<!-- li class="nav-item">
                    <a class="nav-link" href="{{url('customer/patrolling-mission')}}"><i class="fa fa-sign-out-alt"></i> {{__('dashboard.patrolling_mission')}}</a>
                </li -->
                <li class="nav-item">
                    <a class="nav-link" href="{{url('logout')}}"><i class="fa fa-sign-out-alt"></i> {{__('dashboard.logout')}}</a>
                </li>
            </ul>
        </div>
        <div class="Quick_Order_Agent">
            <a href="{{url('customer/quick-create-mission')}}">{{__('dashboard.quick_order_agent')}}</a>
        </div>
    </div>
</div>