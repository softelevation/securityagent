@extends('layouts.app')
@section('content')

<section id="top-banner" class="d-flex flex-column justify-content-center align-items-center">
  <div class="container">
    <!-- <h2>{!!__('frontend.text_55')!!}</h2> -->

    <?php 
      $type = app()->getLocale()=='fr' ? 2 : 1;
      
      $result = $res_data->filter(function($item) use ($type) {
        return $item->type == $type;
      })->first();
    ?>
    
    <h2>{!!html_entity_decode(isset($result->heading)?$result->heading:'')!!}</h2>
    
  </div>
</section>

<section id="section1" class="section1">
  <div class="container">
    <div class="row">
      <div class="col-xl-5 col-lg-5">
        <img style="width: 100%;" class="img-thumbnail" src="{{asset('images/agent_img1.jpg')}}">
      </div>
      <div class="text_panel col-xl-7 col-lg-7">
        <!-- {!!__('frontend.text_56',['url'=>url('register-agent-view')])!!} -->
        {!!html_entity_decode(isset($result->desc)?$result->desc:'')!!}
      </div>
    </div>
  </div>
</section> 

<section>
  <div class="container">
    <div class="row"> 
      <div class="col-md-12">
        <div class="heading text-center">
            <h2>{!!__('frontend.text_57')!!}</h2>           
            <img src="{{asset('assets/images/heading_bottom.png')}}">
        </div>
      </div>
      <div class="col-md-12 text-center">
        <div class="card">
          <div class="card-body text_panel text-left">
            <!-- {!!__('frontend.text_58')!!} -->
            {!!html_entity_decode(isset($result->desc1)?$result->desc1:'')!!}
          </div>
          <img src="{{asset('images/agent_img2.jpg')}}" class="card-img-top">
        </div>
      </div>
      <div class="col-md-12 text_panel mt-3">
        <!-- {!!__('frontend.text_59')!!} -->
        {!!html_entity_decode(isset($result->desc2)?$result->desc2:'')!!}
      </div>
    </div> 
  </div>
</section>
  
@endsection
