<div class="col-md-3 mb-3">
                <div class="Left_tabs_panel border">
                    <div class="profile_img">
                        @if(isset(Auth::user()->operator_info->image) && Auth::user()->operator_info->image!="")
                            <img src="{{asset('profile_images/'.Auth::user()->operator_info->image)}}" class="img-fluid" />
                        @else
                            <img src="{{asset('assets/images/user_img.jpg')}}" class="img-fluid" />
                        @endif
                        <h3>{{Auth::user()->email}} <span>{{__('dashboard.operator')}}</span></h3>
                    </div>
                    <div class="tabs_menu">
                        <ul class="nav flex-column sidebar_nav" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a href="{{url('operator/profile')}}" class="nav-link"><i class="fa fa-user-edit"></i> {{__('dashboard.profile')}}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/missions')}}" class="nav-link"><i class="fa fa-edit"></i> {{__('dashboard.missions')}}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/missions-without-agents')}}" class="nav-link"><i class="fa fa-user-slash"></i> {{__('dashboard.mission.without_agents')}} @if(Helper::get_mission_without_agent_count() > 0)<span class="badge badge-primary badge-pill float-right orange_bg">{{Helper::get_mission_without_agent_count()}}</span>@endif</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/agents')}}" class="nav-link"><i class="fa fa-user-secret"></i> &nbsp; {{__('dashboard.agents.agents')}}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/customers')}}" class="nav-link"><i class="fa fa-user-tie"></i> &nbsp;{{__('dashboard.customers')}}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/billing-details')}}" class="nav-link"><i class="fa fa-file-invoice"></i> &nbsp; {{__('dashboard.billing')}}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/payment-approvals')}}" class="nav-link"><i class="fa fa-money-check-alt"></i> {{__('dashboard.payment.approvals')}} @if(Helper::get_payment_approval_count() > 0)<span class="badge badge-primary badge-pill float-right orange_bg">{{Helper::get_payment_approval_count()}}</span>@endif</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/refund-requests')}}" class="nav-link"><i class="fa fa-wallet"></i> {{__('dashboard.payment.refund_req')}} @if(Helper::get_refund_request_count() > 0)<span class="badge badge-primary badge-pill float-right orange_bg">{{Helper::get_refund_request_count()}}</span>@endif</a>  
                                <a href="{{url('operator/missions?archived=1')}}" class="nav-link"><i class="fa fa-edit"></i> {{__('dashboard.mission.archive_mission')}}</a>  
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="{{url('operator/message-center')}}"><i class="fa fa-message_center"></i> {{__('dashboard.mission.message_center')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('logout')}}"><i class="fa fa-sign-out-alt"></i> {{__('dashboard.logout')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('operator/agent_information_edit')}}"><i class="fa fa-sign-out-alt"></i> {{__('dashboard.mission.agent_information_edit')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('operator/agent_information_edit_fr')}}"><i class="fa fa-sign-out-alt"></i> {{__('dashboard.mission.agent_information_edit_fr')}}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- <div class="Quick_Order_Agent">
                        <a href="#">Quick Order My Agent</a>
                    </div> -->
                </div>
            </div>