<div class="col-md-3 mb-3">
                <div class="Left_tabs_panel border">
                    <div class="profile_img">
                        <img src="{{asset('assets/images/user_img.jpg')}}" class="img-fluid" />
                        <h3>{{Auth::user()->email}} <span>Operator</span></h3>
                    </div>
                    <div class="tabs_menu">
                        <ul class="nav flex-column sidebar_nav" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a href="{{url('operator/profile')}}" class="nav-link"><i class="fa fa-user-edit"></i> Change My Profile</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/missions')}}" class="nav-link"><i class="fa fa-edit"></i> Missions</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/agents')}}" class="nav-link"><i class="fa fa-user-secret"></i> &nbsp; Agents</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('operator/customers')}}" class="nav-link"><i class="fa fa-user-tie"></i> &nbsp;Customers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"><i class="fa fa-file-invoice"></i> &nbsp;Billing</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('logout')}}"><i class="fa fa-sign-out-alt"></i> Log Out</a>
                            </li>
                        </ul>
                    </div>
                    <div class="Quick_Order_Agent">
                        <a href="#">Quick Order My Agent</a>
                    </div>
                </div>
            </div>