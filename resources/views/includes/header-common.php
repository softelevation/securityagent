<div id="Header">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="<?php echo url('/'); ?>"><img src="<?php echo asset('assets/images/logo.jpg'); ?>"/></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <div class="main_menu">
            <div class="menu_left">
                <div class="top_menu">
                    <ul>
                        <?php if(\Auth::check()){ ?>
                          <li>
                            <div class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown"><img class="rounded-circle" width="25" src="<?php echo asset('avatars/dummy_avatar.jpg'); ?>"/> <?php echo __('frontend.text_82'); ?>
                              <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="<?php echo url('login'); ?>"><?php echo __('frontend.text_83'); ?></a></li>
                                <li><a href="<?php echo url('logout'); ?>"><?php echo __('frontend.text_84'); ?></a></li>
                              </ul>
                            </div>
                          </li>
                        <?php }else{ ?>
                          <li><a href="<?php echo url('/login'); ?>"><?php echo __('frontend.text_74'); ?></a></li> 
                        <?php }?>
                        <em>|</em>  
                        <!-- <li><a href="">Registration</a></li> -->
                        <li><div class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown">
                            <?php if(app()->getLocale()=='fr'){ ?>
                              <img height="18" src="<?php echo asset('assets/images/france_flag.png'); ?>">
                              French
                            <?php }else{ ?>
                              <img src="<?php echo asset('assets/images/usa_flag.png'); ?>">
                              English  
                            <?php } ?>
                          <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="<?php echo url('change-language/en'); ?>">English</a></li>
                            <li><a href="<?php echo url('change-language/fr'); ?>">French</a></li>
                          </ul>
                        </div></li>
                    </ul>
                </div>
                <div class="primary">
                    <ul>
                        <li><a class="<?php if(url()->current()==url('/')){ ?> active <?php } ?>" href="<?php echo url('/'); ?>"><?php echo __('frontend.text_75'); ?></a></li>
                        <li><a class="<?php if(url()->current()==url('/available-agents')){ ?> active <?php } ?>" href="<?php echo url('/available-agents'); ?>"><?php echo __('frontend.text_76'); ?></a></li>
                        <li><a class="<?php if(url()->current()==url('/agent_information')){ ?> active <?php } ?>" href="<?php echo url('/agent_information'); ?>"><?php echo __('frontend.text_77'); ?></a></li>
                        <li><a href="<?php echo url('/blog'); ?>"><?php echo __('frontend.text_78'); ?></a></li>
                        <li><a class="<?php if(url()->current()==url('/contact-us')){ ?> active <?php } ?>" href="<?php echo url('/contact-us'); ?>"><?php echo __('frontend.text_79'); ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="menu_right">
              <?php if(\Auth::check()){ ?>
                <!-- If agent is logged in -->
                <?php if(\Auth::user()->role_id==2) { ?>
                  <div class="availability-section">
                    <!-- Notifications Dropdown -->
                    <div class="float-left dropdown pl-3 position-relative">
                      <div class="notification" data-toggle="dropdown">
                        <span <?php if(Helper::get_misison_request_count()==0){ ?> data-container="body" data-toggle="popover" data-placement="bottom" data-content="<?php echo __('dashboard.no_notification'); ?>" data-html="true" data-trigger="hover" <?php } ?>><i class="fa fa-bell"></i></span>
                        <?php if(Helper::get_misison_request_count() > 0){ ?>
                          <span class="badge"><?php echo Helper::get_misison_request_count(); ?></span>
                        <?php } ?>
                      </div>
                      <?php if(Helper::get_misison_request_count() > 0){ ?>
                      <ul class="dropdown-menu mission-requests">
                        <li class="item"><a href="<?php echo url('agent/mission-requests'); ?>"><i class="fa fa-edit"></i> <?php echo Helper::get_misison_request_count(); ?> New mission request</a></li>
                      </ul>
                      <?php } ?>
                    </div>
                    <!-- Availability -->
                    <div class="float-right">
                      <span class="pr-3"><?php echo __('frontend.text_85'); ?></span> 
                      <label class="switch">
                        <input 
                        <?php if(\Auth::user()->agent_info->available==2){ ?> disabled="disabled" <?php } ?> 
                        type="checkbox" id="availability_check_btn" class="check" 
                        <?php if(\Auth::user()->agent_info->available==1){ ?> checked <?php } ?>>
                        <span 
                        <?php if(\Auth::user()->agent_info->available==2){ ?> 
                        data-container="body" data-toggle="popover" data-placement="bottom" data-content="During ongoing mission, availability status can't be changed." data-html="true" data-trigger="hover" <?php } ?> class="slider round"></span>
                      </label>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                <?php } ?>
                <!-- if customer is logged in -->
                <?php if(\Auth::user()->role_id==1){ ?>
                  <div class="availability-section">
                    <!-- Notifications Dropdown -->
                    <div class="float-left dropdown pl-3 position-relative">
                      <div class="notification" data-toggle="dropdown">
                        <span <?php if(Helper::get_customer_notification_count()==0){ ?> data-container="body" data-toggle="popover" data-placement="bottom" data-content="No new notification." data-html="true" data-trigger="hover" <?php } ?>><i class="fa fa-bell"></i></span>
                        <?php if(Helper::get_customer_notification_count() > 0){ ?>
                          <span class="badge"><?php echo Helper::get_customer_notification_count(); ?></span>
                        <?php } ?>
                      </div>
                      <?php if(Helper::get_customer_notification_count() > 0){ ?>
                      <ul class="dropdown-menu mission-requests">
                        <?php $notifications = Helper::get_customer_notifications(); ?>
                        <?php foreach($notifications as $notification){ ?>
                        <li class="item"><a class="notification-item" href="javascript:void(0)" data-notification-url="<?php echo url('customer/mission-details/view/'); ?>/<?php echo Helper::encrypt($notification->mission_id); ?>" data-notification-id="<?php echo $notification->id; ?>"><i class="fa fa-edit"></i> {{__($notification->content)}}</a></li>
                        <?php }?>
                      </ul>
                      <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                <?php } ?>
              <?php }else{ ?>
                <a href="<?php echo url('/register-agent-view'); ?>"><?php echo __('frontend.text_80'); ?></a>
                <a href="<?php echo url('/customer-signup'); ?>"><?php echo __('frontend.text_81'); ?></a>
              <?php } ?>
            </div>  
        </div>
      </div>
    </div>
  </nav>
</div>