<div class="col-md-3 mb-3">
    <div class="Left_tabs_panel border">
        <div class="profile_img">
            @if(isset(Auth::user()->agent_info->image) && Auth::user()->agent_info->image!="")
                <img src="{{asset('profile_images/'.Auth::user()->agent_info->image)}}" class="img-fluid" />
            @else
                <img src="{{asset('assets/images/user_img.jpg')}}" class="img-fluid" />
            @endif
            <h3>{{Auth::user()->email}} <span><i style="font-size: 11px;" class="fa fa-circle 
                @if(Auth::user()->agent_info->available==1) text-success @endif
                @if(Auth::user()->agent_info->available==0) text-danger @endif
                @if(Auth::user()->agent_info->available==2) text-warning @endif" aria-hidden="true"></i> {{__('dashboard.agent')}}</span></h3>
        </div>
        <div class="tabs_menu">
            <ul class="nav flex-column sidebar_nav" id="myTab" role="tablist">
                <li class="nav-item">
                    <a href="{{url('agent/profile')}}" class="nav-link"><i class="fa fa-user-edit"></i> {{__('dashboard.profile')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{url('agent/mission-requests')}}" class="nav-link"><i class="fa fa-tasks"></i> {{__('dashboard.mission_requests')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{url('agent/missions')}}" class="nav-link"><i class="fa fa-edit"></i> {{__('dashboard.missions')}}</a>
                </li>
                <li class="nav-item">
                    <a href="{{url('agent/schedule')}}/{{Helper::encrypt(Auth::user()->agent_info->id)}}" class="nav-link"><i class="fa fa-calendar-alt"></i> {{__('dashboard.schedule')}}</a>
                </li>
				<li class="nav-item">
                    <a class="nav-link" href="{{url('agent/message-center')}}"><i class="fa fa-message_center"></i> {{__('dashboard.mission.message_center')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('logout')}}"><i class="fa fa-sign-out-alt"></i> {{__('dashboard.logout')}}</a>
                </li>
                <li class="nav-item text-center total_hours">
                    <a class="nav-link" href="javascript:void(0)"><i class="fa fa-clock"></i> <span>{{Helper::get_total_worked_hours(Auth::user()->agent_info->id)}}</span><br><small>{{__('dashboard.agents.total_hours_worked')}}</small></a>
                </li>
            </ul>
        </div>
    </div>
</div>