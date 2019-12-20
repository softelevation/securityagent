<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Profile | On Time</title>

  <!-- Bootstrap core CSS -->
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">

</head>

<body>
<div id="Header">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="index.html"><img src="{{asset('assets/images/logo.jpg')}}"/></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <div class="main_menu">
            <div class="menu_left">
                <div class="top_menu">
                    <ul>
                        <li><a href="">Login</a></li> <em>|</em>  <li><a href="">Registration</a></li>
                        <li><div class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('assets/images/usa_flag.png')}}"/> USA
                          <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="#">USA</a></li>
                            <li><a href="#">Australia</a></li>
                            <li><a href="#">India</a></li>
                          </ul>
                        </div></li>
                    </ul>
                </div>
                <div class="primary">
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="available-agent.html">Available Agent on Map</a></li>
                        <li><a href="contact.html">Contact us</a></li>
                    </ul>
                </div>
            </div>  
            <div class="menu_right">
                <a type="button" data-toggle="modal" data-target="#become_agent">Become an Agent</a>
                <a type="button" data-toggle="modal" data-target="#become_agent">Become an User</a>
            </div>
        </div>
      </div>
    </div>
  </nav>
</div>

 <div class="profile">
    <div class="container">
  <div class="row">
    <div class="col-md-3 mb-3">
        <div class="Left_tabs_panel border">
        <div class="profile_img">
            <img src="{{asset('assets/images/user_img.jpg')}}" class="img-fluid"/>
            <h3>Rechard Reo <span>Brooklyn, New-york</span></h3>
        </div>
        <div class="tabs_menu">
            <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="ChangeMyProfile-tab" data-toggle="tab" href="#ChangeMyProfile" role="tab" aria-controls="ChangeMyProfile" aria-selected="true"><img src="{{asset('assets/images/change_profile_icon.png')}}"/> Change My Profile</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="CreateMission-tab" data-toggle="tab" href="#CreateMission" role="tab" aria-controls="CreateMission" aria-selected="false"><img src="{{asset('assets/images/create_mission_icon.png')}}"/> Create a Mission</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="Agents-tab" data-toggle="tab" href="#Agents" role="tab" aria-controls="Agents" aria-selected="false"><img src="{{asset('assets/images/change_profile_icon.png')}}"/> Agents</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="Billing-tab" data-toggle="tab" href="#Billing" role="tab" aria-controls="Billing" aria-selected="false"><img src="{{asset('assets/images/billing_icon.png')}}"/> Billing</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="LogOut-tab" data-toggle="tab" href="#LogOut" role="tab" aria-controls="LogOut" aria-selected="false"><img src="{{asset('assets/images/LogOut_icon.png')}}"/> Log Out</a>
              </li>
            </ul>
        </div>
        <div class="Quick_Order_Agent">
            <a href="#">Quick Order My Agent</a>
        </div>    
    </div>
        </div>
    <!-- /.col-md-4 -->
        <div class="col-md-9">
      <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="ChangeMyProfile" role="tabpanel" aria-labelledby="ChangeMyProfile-tab">
  <h2>Change My Profile</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>
  </div>
          <div class="tab-pane fade" id="CreateMission" role="tabpanel" aria-labelledby="CreateMission-tab">
  <h2>Profile</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>
  </div>
  <div class="tab-pane fade" id="Agents" role="tabpanel" aria-labelledby="Agents-tab">
      <div class="border">
         <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#VerificationPending">Verification Pending</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#VerifiedAgent">Verified Agent</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="VerificationPending" class="tab-pane active">
      <div class="table-responsive">
        <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Employee Name</th> 
            <th>Employee Job Title</th>
            <th>E-mail Address</th>
            <th>Manager Job Title</th> 
            <th>Action</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{asset('assets/images/dots.png')}}">
                             </a>
                             <div class="dropdown-menu fadeIn">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target=""><i class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-unlock" aria-hidden="true"></i> Block/Unblock</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{asset('assets/images/dots.png')}}">
                             </a>
                             <div class="dropdown-menu fadeIn">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target=""><i class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-unlock" aria-hidden="true"></i> Block/Unblock</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{asset('assets/images/dots.png')}}">
                             </a>
                             <div class="dropdown-menu fadeIn">
                               <a class="dropdown-item" href="" data-toggle="modal" data-target="#Renew"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</a>
                                <a class="dropdown-item" href=""><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{asset('assets/images/dots.png')}}">
                             </a>
                             <div class="dropdown-menu fadeIn">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#Renew"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</a>
                                <a class="dropdown-item" href=""><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{asset('assets/images/dots.png')}}">
                             </a>
                             <div class="dropdown-menu fadeIn">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#Renew"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</a>
                                <a class="dropdown-item" href=""><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{asset('assets/images/dots.png')}}">
                             </a>
                             <div class="dropdown-menu fadeIn">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#Renew"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</a>
                                <a class="dropdown-item" href=""><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{asset('assets/images/dots.png')}}">
                             </a>
                             <div class="dropdown-menu fadeIn">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#Renew"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</a>
                                <a class="dropdown-item" href=""><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{asset('assets/images/dots.png')}}">
                             </a>
                             <div class="dropdown-menu fadeIn">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#Renew"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</a>
                                <a class="dropdown-item" href=""><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr> 
           </tbody>
       </table>
    </div>
    <div class="row">
     <div class="ml-auto mr-auto">
        <nav class="navigation2 text-center" aria-label="Page navigation">
           <ul class="pagination mb-3">
              <li class="page-item"><a class="page-link" href="#"><span aria-hidden="true">←</span>Prev</a></li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">Next <span aria-hidden="true">→</span></a></li>
           </ul>
        </nav>
     </div>
  </div>
    </div>
    <div id="VerifiedAgent" class="tab-pane fade">
      <div class="table-responsive">
        <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Employee Name</th> 
            <th>Employee Job Title</th>
            <th>E-mail Address</th>
            <th>Manager Job Title</th> 
            <th>Action</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{asset('assets/images/dots.png')}}">
                             </a>
                             <div class="dropdown-menu fadeIn">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target=""><i class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-unlock" aria-hidden="true"></i> Block/Unblock</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="images/dots.png">
                             </a>
                             <div class="dropdown-menu fadeIn">
                               <a class="dropdown-item" href="" data-toggle="modal" data-target="#Renew"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</a>
                                <a class="dropdown-item" href=""><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="images/dots.png">
                             </a>
                             <div class="dropdown-menu fadeIn">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#Renew"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</a>
                                <a class="dropdown-item" href=""><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="images/dots.png">
                             </a>
                             <div class="dropdown-menu fadeIn">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#Renew"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</a>
                                <a class="dropdown-item" href=""><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="images/dots.png">
                             </a>
                             <div class="dropdown-menu fadeIn">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#Renew"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</a>
                                <a class="dropdown-item" href=""><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="images/dots.png">
                             </a>
                             <div class="dropdown-menu fadeIn">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#Renew"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</a>
                                <a class="dropdown-item" href=""><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td><a href="">James Martin</a></td> 
                    <td>Replacement Electric</td>
                    <td>jamesmartin@gmail.com</td> 
                    
                    <td>Replacement Electric</td>
                    <td>
                        <div class="dropdown ac-cstm">
                             <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="images/dots.png">
                             </a>
                             <div class="dropdown-menu fadeIn">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#Renew"><i class="fa fa-refresh" aria-hidden="true"></i> Renew</a>
                                <a class="dropdown-item" href=""><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr> 
           </tbody>
       </table>
    </div>
    <div class="row">
     <div class="ml-auto mr-auto">
        <nav class="navigation2 text-center" aria-label="Page navigation">
           <ul class="pagination mb-3">
              <li class="page-item"><a class="page-link" href="#"><span aria-hidden="true">←</span>Prev</a></li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">Next <span aria-hidden="true">→</span></a></li>
           </ul>
        </nav>
     </div>
  </div>
    </div>
  </div>
  </div>
  </div>
<div class="tab-pane fade" id="Billing" role="tabpanel" aria-labelledby="Billing-tab">
  <h2>Contact</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>
  
  </div>
<div class="tab-pane fade" id="LogOut" role="tabpanel" aria-labelledby="LogOut-tab">
  <h2>Contact</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>  
  </div>         
</div>
    </div>
    <!-- /.col-md-8 -->
  </div>
  
  
  
</div>
<!-- /.container -->    
  </div>
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
                    <li><a href="contact.html"><i class="fa fa-share" aria-hidden="true"></i> contact</a></li>
                    <li><a href="available-agent.html"><i class="fa fa-share" aria-hidden="true"></i> available agent on map</a></li>
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
            <p>Copyright © 2019 - Alright reserved by <b>OnTimeBee</b>. Design By: <b>Toukir Rahman</b></p>
        </div>
    </div>
  </footer>

    
    
    <!-- Trigger the modal with a button -->


<!-- Modal -->
<div id="become_agent" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Become an Agent</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" placeholder="Enter Your First Name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" placeholder="Enter Your Last Name" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Email Address</label>
                <input type="text" class="form-control" placeholder="Enter Your Email" />
              </div>
            </div>
              <div class="col-md-6">
              <div class="form-group">
                <label>Phone Number</label>
                <input type="text" class="form-control" placeholder="Enter Your Phone Number" />
              </div>
            </div>
         </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Message</label>
                <textarea class="form-control" placeholder="Enter Your Message"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="submit" class="yellow_btn" value="Become Agent"/>
              </div>
            </div>
          </div>          
      </div>
    </div>

  </div>
</div>
  <!-- Bootstrap core JavaScript -->
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

</body>

</html>
