@extends('layouts.app')
@section('content')
<div class="contact_panel">
  <div class="container">
    <div class="row"> 
        <div class="col-md-12">
            <div class="contact_box">
                <h3><i class="fa fa-pin"></i> {{__('frontend.text_147')}}</h3>
                <div class="contact_form">
                  {{Form::open(['url'=>url('suport-ticket'),'id'=>'general_form'])}}
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label><b>{{__('frontend.text_150')}}</b></label>
                        <input type="text" name="email" value="Support@ontimebe.com" class="form-control" placeholder="Support@ontimebe.com" />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>{{__('frontend.text_65')}}:</label>
                        <input type="text" name="subject" class="form-control" placeholder="{{__('frontend.text_145')}}"/>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>{{__('frontend.text_146')}}:</label>
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