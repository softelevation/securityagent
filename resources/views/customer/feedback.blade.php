@extends('layouts.app')
@section('content')
<style>
.star-rating__stars {
  position: relative;
  height: 5rem;
  width: 25rem;
  background: url('./../../images/off.svg');
  background-size: 5rem 5rem;
}

.star-rating__label {
  position: absolute;
  height: 100%;
  background-size: 5rem 5rem;
}

.star-rating__input {
  margin: 0;
  position: absolute;
  height: 1px; width: 1px;
  overflow: hidden;
  clip: rect(1px, 1px, 1px, 1px);
}

.star-rating__stars .star-rating__label:nth-of-type(1) {
  z-index: 5;
  width: 20%;
}

.star-rating__stars .star-rating__label:nth-of-type(2) {
  z-index: 4;
  width: 40%;
}

.star-rating__stars .star-rating__label:nth-of-type(3) {
  z-index: 3;
  width: 60%;
}

.star-rating__stars .star-rating__label:nth-of-type(4) {
  z-index: 2;
  width: 80%;
}

.star-rating__stars .star-rating__label:nth-of-type(5) {
  z-index: 1;
  width: 100%;
}

.star-rating__input:checked + .star-rating__label,
.star-rating__input:focus + .star-rating__label,
.star-rating__label:hover {
  background-image: url('./../../images/on.svg');
}

.star-rating__label:hover ~ .star-rating__label {
  background-image: url('./../../images/off.svg');
}

.star-rating__input:focus ~ .star-rating__focus {
  position: absolute;
  top: -.25em;
  right: -.25em;
  bottom: -.25em;
  left: -.25em;
  outline: 0.25rem solid lightblue;
}
</style>
<div class="contact_panel">
  <div class="container">
    <div class="row">    
        <div class="col-md-12">
            <div class="contact_box">
                <h3>{{__('dashboard.agents.details')}}</h3>
                <div class="profile_detail_box">
                  <div class="row p-4">
                    <div class="col-md-3 text-center">
                      <div>
						@if($agent->image && !empty($agent->image))
							<img class="rounded-circle avatar-image" src="{{asset('profile_images/'.$agent->image)}}">
						@else
							<img class="rounded-circle avatar-image" src="{{asset('avatars/'.$agent->avatar_icon)}}">
						@endIf
                      </div>
                      <div class="pt-3">
                        <p class="review-star">
                                <span class="fa fa-star @if($agent->rating >= 1) checked @endIf"></span>
                                <span class="fa fa-star @if($agent->rating >= 2) checked @endIf"></span>
                                <span class="fa fa-star @if($agent->rating >= 3) checked @endIf"></span>
                                <span class="fa fa-star @if($agent->rating >= 4) checked @endIf"></span>
                                <span class="fa fa-star @if($agent->rating >= 5) checked @endIf"></span>
                        </p>
                      </div>
                      <div>
                        <ul class="details-list">
                          <li><span>{{Helper::get_total_missin_completed($agent->id)}}</span> {{__('dashboard.mission.mission_completed')}}</li>
                          <li><span>{{round(Helper::get_total_worked_hours($agent->id))}}</span> {{__('dashboard.mission.hours_completed')}}</li>
                          <li>@if($agent->is_vehicle==1) {!!__('dashboard.mission.have_vehicle')!!} @else {{__('dashboard.mission.no_vehicle')}} @endif</li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="">
                        <h4>{{$agent->username}}</h4>
                        <hr>
                        <h6>{{Helper::get_agent_type_name_multiple($agent->agent_type)}}</h6>
                      </div>
					  
					  <form id="general_form" method="post" action="{{url('customer/feedback/'.$id)}}">
						@csrf
                      <div class="row">
                        <div class="col-md-12">
                          <h3>{{__('dashboard.agents.reviews')}}</h3>
                          <div class="row review-wrapper">
                            <div class="star-rating__stars">
							  <input class="star-rating__input" name="rating" type="radio" name="rating" value="1" id="rating-1" @if($is_submit) disabled @endIf @if($feedback->rating == 1) checked @endIf />
							  <label class="star-rating__label" for="rating-1" aria-label="One"></label>
							  <input class="star-rating__input" name="rating" type="radio" name="rating" value="2" id="rating-2" @if($is_submit) disabled @endIf @if($feedback->rating == 2) checked @endIf />
							  <label class="star-rating__label" for="rating-2" aria-label="Two"></label>
							  <input class="star-rating__input" name="rating" type="radio" name="rating" value="3" id="rating-3" @if($is_submit) disabled @endIf @if($feedback->rating == 3) checked @endIf />
							  <label class="star-rating__label" for="rating-3" aria-label="Three"></label>
							  <input class="star-rating__input" name="rating" type="radio" name="rating" value="4" id="rating-4" @if($is_submit) disabled @endIf @if($feedback->rating == 4) checked @endIf />
							  <label class="star-rating__label" for="rating-4" aria-label="Four"></label>
							  <input class="star-rating__input" name="rating" type="radio" name="rating" value="5" id="rating-5" @if($is_submit) disabled @endIf @if($feedback->rating == 5) checked @endIf />
							  <label class="star-rating__label" for="rating-5" aria-label="Five"></label>
							  <div class="star-rating__focus"></div>
							</div>
                          </div>
						  <div class="row review-wrapper">
							<div class="col-md-12 form-group">
							  <label>{{__('frontend.text_71')}}</label>
                              <textarea name="message" class="form-control" @if($is_submit) disabled @endIf>{{$feedback->message}}</textarea>
							</div>
                          </div>
						  @if(!$is_submit)
						  <div class="row review-wrapper">
							<div class="col-md-12 form-group">
                              <input type="submit" class="yellow_btn" value="{{__('frontend.text_73')}}"/>
							</div>
                          </div>
						  @endIf
                        </div>
                      </div>
					  </form>
                     
                    </div>
                  </div>
                </div>
            </div>
        </div>        
    </div>  
    </div>
</div>
@endsection