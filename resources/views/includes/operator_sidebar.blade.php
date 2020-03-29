<div class="col-md-3 mb-3">
                <div class="Left_tabs_panel border">
                    <div class="profile_img">
                        @if(isset(Auth::user()->operator_info->image) && Auth::user()->operator_info->image!="")
                            <img src="{{asset('profile_images/'.Auth::user()->operator_info->image)}}" class="img-fluid" />
                        @else
                            <img src="{{asset('assets/images/user_img.jpg')}}" class="img-fluid" />
                        @endif
                        <h3>{{Auth::user()->email}} <span>Operator</span></h3>
                    </div>
                    <div class="tabs_menu">
                        <ul class="nav flex-column sidebar_nav" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a href="{{url('operator/profile')}}" class="nav-link"><i class="fa fa-user-edit"></i> Profile</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/missions')}}" class="nav-link"><i class="fa fa-edit"></i> Missions</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/missions-without-agents')}}" class="nav-link"><i class="fa fa-user-slash"></i> Missions Without Agents @if(Helper::get_mission_without_agent_count() > 0)<span class="badge badge-primary badge-pill float-right orange_bg">{{Helper::get_mission_without_agent_count()}}</span>@endif</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/agents')}}" class="nav-link"><i class="fa fa-user-secret"></i> &nbsp; Agents</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/customers')}}" class="nav-link"><i class="fa fa-user-tie"></i> &nbsp;Customers</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/billing-details')}}" class="nav-link"><i class="fa fa-file-invoice"></i> &nbsp; Billing</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/payment-approvals')}}" class="nav-link"><i class="fa fa-money-check-alt"></i> Payment Approvals @if(Helper::get_payment_approval_count() > 0)<span class="badge badge-primary badge-pill float-right orange_bg">{{Helper::get_payment_approval_count()}}</span>@endif</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/refund-requests')}}" class="nav-link"><i class="fa fa-wallet"></i> Refund Requests @if(Helper::get_refund_request_count() > 0)<span class="badge badge-primary badge-pill float-right orange_bg">{{Helper::get_refund_request_count()}}</span>@endif</a>  
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('logout')}}"><i class="fa fa-sign-out-alt"></i> Log Out</a>
                            </li>
                        </ul>
                    </div>
                    <!-- <div class="Quick_Order_Agent">
                        <a href="#">Quick Order My Agent</a>
                    </div> -->
                </div>
            </div>