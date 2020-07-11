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
                        <p>Be On Time SAS <br/>66 Avenue des Champs-Elysées<br/>75008 Paris<br><b>01 83 62 52 14</b><br><a href="mailto:contact@ontimebe.com">contact@ontimebe.com</a></p>
                    </div>
                    <div class="address_box">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.33361118055!2d2.303238315640143!3d48.87091647928871!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66fc3c52c6deb%3A0x9eda90a43280f6b0!2s66%20Av.%20des%20Champs-%C3%89lys%C3%A9es%2C%2075008%20Paris%2C%20France!5e0!3m2!1sen!2sin!4v1586073334006!5m2!1sen!2sin" width="100%" height="165" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
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