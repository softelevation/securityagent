@extends('layouts.app')
@section('content')
<div class="contact_panel">
  <div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="contact_box">
                <h3><i class="fa fa-pin"></i> {{__('frontend.text_60')}}</h3>
                <div class="contact_form">
                    <div class="address_box">
                        <h4>{{__('frontend.text_72')}}:</h4>
                        <p>Be On Time SAS <br/>13 rue Washington<br/>75008 Paris<br><b>01 83 62 52 14</b><br><a href="mailto:contact@ontimebe.com">contact@ontimebe.com</a></p>
                    </div>
                    <div class="address_box">
                        <iframe src="https://maps.google.com/maps?q=13%20rue%20Washington%2075008%20Paris&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="165" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
            </div>
        </div>    
        <div class="col-md-8">
            <div class="contact_box">
                <h3><i class="fa fa-pin"></i> {{__('frontend.text_61')}}</h3>
                <div class="contact_form">
                  {{Form::open(['url'=>url('contact-form-submission'),'id'=>'general_form'])}}
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>{{__('frontend.text_62')}}:</label>
                        <input type="text" name="name" class="form-control" placeholder="{{__('frontend.text_67')}}" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>{{__('frontend.text_63')}}:</label>
                        <input type="email" name="email" class="form-control" placeholder="{{__('frontend.text_68')}}" />
                      </div>
                    </div>
                      <div class="col-md-4">
                      <div class="form-group">
                        <label>{{__('frontend.text_64')}}:</label>
                        <input type="text" name="phone" class="form-control" placeholder="{{__('frontend.text_69')}}" />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>{{__('frontend.text_65')}}:</label>
                        <input type="text" name="subject" class="form-control" placeholder="{{__('frontend.text_70')}}"/>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>{{__('frontend.text_66')}}:</label>
                        <textarea name="feedback" class="form-control" placeholder="{{__('frontend.text_71')}}"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group text-center mb-0 ">
                        <input type="submit" class="yellow_btn" value="{{__('frontend.text_73')}}"/>
                      </div>
                    </div>
                  </div>
                  {{Form::close()}}  
                </div>
            </div>
        </div>        
    </div>  
    </div>
</div>
@endsection