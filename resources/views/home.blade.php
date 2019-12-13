@extends('layouts.app')
@section('content')
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="banner_cont">
                    <h1>Votre agent de securite des que possible</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="map_panel text-center">
                    <h2>Les Meilleurs sont pres de chez vous</h2>    
                    <p>Search by city, address, postalcode, etc...</p>
                    <div class="locationSearch">
                        <input type="search" class="form-control" placeholder="Type location here"/>
                        <span><i class="fa fa-paper-plane"></i></span>
                    </div>
                    <a href="#" class="yellow_btn">Search Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="comment_panel">
    <div class="container">
        <div class="heading text-center">
            <h2>Comment Ca Marche ?</h2>
            <img src="{{asset('assets/images/heading_bottom.png')}}"/>
        </div>
        <p>Lorem Ipsum est un générateur de faux textes aléatoires. Vous choisissez le nombre de paragraphes, de mots ou de listes. Vous obtenez alors un texte aléatoire que vous pourrez ensuite utiliser librement dans vos maquettes. Lorem Ipsum est un générateur de faux textes aléatoires. Vous choisissez  Vous obtenez alors un librement dans vos maquettes.</p>
    </div>
</div>    
<div class="feature_panel">
    <div class="feature_panel_inner">
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-right">
                    <div class="feature_box">
                        <span><img src="{{asset('assets/images/awesome_icon.png')}}"/></span>
                        <h3>Awesome Features</h3>
                        <p>Purus ipsum neque primis libero tempor posuere in ligula varius ipsum</p>
                    </div>
                     <div class="feature_box">
                        <span><img src="{{asset('assets/images/platform_icon.png')}}"/></span>
                        <h3>Cross-Platform</h3>
                        <p>Semper a augue suscript, luctus neque purus ipsum neque primis libero</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature_img">
                        <img src="{{asset('assets/images/mobile_img.png')}}" alt=""/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature_box">
                        <span><img src="{{asset('assets/images/update_icon.png')}}"/></span>
                        <h3>Free Updates</h3>
                        <p>Purus ipsum neque primis libero tempor posuere in ligula varius ipsum</p>
                    </div>
                     <div class="feature_box">
                        <span><img src="{{asset('assets/images/support_icon.png')}}"/></span>
                        <h3>Fast-Support</h3>
                        <p>Purus ipsum neque primis libero tempor posuere in ligula varius ipsum</p>
                    </div>
                </div>
            </div>
        </div>                      
    </div>  
</div>
<div class="how_works">
    <div class="container">
        <div class="heading text-center">
            <h2>How It Works?</h2>
            <img src="{{asset('assets/images/heading_bottom.png')}}"/>
        </div> 
        <div class="row">
            <div class="col-md-6">
                <div class="agent">
                    <h4>Agent</h4>
                    <img src="{{asset('assets/images/agent.jpg')}}"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="customer">
                    <h4>Customer</h4>
                    <img src="{{asset('assets/images/customer.jpg')}}"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="how_work_listing">
                    <ul>
                        <li><a href=""><img src="{{asset('assets/images/search_img.png')}}"/> Inscrivez-vous et creez votre annonce</a></li>
                        <li><a href=""><img src="{{asset('assets/images/copy_img.png')}}"/> Effectuez vos recherches</a></li>
                        <li><a href=""><img src="{{asset('assets/images/calling_img.png')}}"/> Contactez les agents dispoibles</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="testimonial_panel">
    <div class="container">
        <div class="heading text-center">
            <h2>Nos Derniers Temoigna</h2>
            <img src="{{asset('assets/images/heading_bottom.png')}}"/>
        </div>  
        <div class="row">
            <div class="col-md-4">
                <div class="testimonial_box">
                    <div class="testimonial_cont">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
                    </div>
                    <div class="testimonial_img_name">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="testimonial_img">
                                    <img src="{{asset('assets/images/testi_person1.jpg')}}"/>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="testimonial_name">
                                    <h4>Robert Peterson</h4>
                                    <div class="star">
                                        <img src="{{asset('assets/images/star.jpg')}}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial_box">
                    <div class="testimonial_cont">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
                    </div>
                    <div class="testimonial_img_name">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="testimonial_img">
                                    <img src="{{asset('assets/images/testi_person2.jpg')}}"/>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="testimonial_name">
                                    <h4>Evelyn Martinez</h4>
                                    <div class="star">
                                        <img src="{{asset('assets/images/star.jpg')}}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial_box">
                    <div class="testimonial_cont">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
                    </div>
                    <div class="testimonial_img_name">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="testimonial_img">
                                    <img src="{{asset('assets/images/testi_person3.jpg')}}"/>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="testimonial_name">
                                    <h4>Dan Hodges</h4>
                                    <div class="star">
                                        <img src="{{asset('assets/images/star.jpg')}}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>     
@endsection  
