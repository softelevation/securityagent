@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
     
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.mission.mission')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3><i class="fa fa-edit"></i> {{__('dashboard.payment.mission')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                  <h5>{{__('dashboard.payment.to_paid')}}: {{$charge_amount}} <i class="fa fa-euro-sign"></i></h5>
                    <!-- Added cards -->
                    @if(!empty($cards))
                    <div class="table-responsive">
                      <table class="table table-hover table-striped">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>{{__('dashboard.payment.holder_name')}}</th>
                                  <th>{{__('dashboard.payment.card_no')}}</th>
                                  <th>{{__('dashboard.payment.exp_date')}}</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                            @php $i = 0; @endphp
                            @foreach($cards as $card)
                              @php $i++; @endphp
                              <tr>
                                  <td>{{$i}}.</td>
                                  <td>{{$card->name}}</td>
                                  <td>{{$card->card_number}}</td>
                                  <td>{{$card->expire_month}}/{{$card->expire_year}}</td>
                                  <td>
								  <!-- a id="{{$card->id}}" href="javascript:void(0)" class="btn_submit pay_now_btn"> {{__('dashboard.payment.now')}}</a -->
								  
								  <div class="dropdown">
									  <a class="action_icons dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-list text-grey" aria-hidden="true"></i> Actions</a>
									  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a class="dropdown-item add_new_card_btn_pay" data-name="{{$card->name}}" data-card_number="{{$card->card_number}}" data-expire_month="{{$card->expire_month}}" data-expire_year="{{$card->expire_year}}" href="javascript:void(0)"><i class="fas fa-edit text-grey" aria-hidden="true"></i>{{__('dashboard.payment.now')}}</a>
										<a href="../card-delete/{{$card->id}}" class="dropdown-item delete_ajaxfun_cls"><i class="fas fa-trash-alt text-grey" aria-hidden="true"></i> {{__('dashboard.mission.delete')}}</a>
									  </div>
								  </div>
								  </td>
                              </tr>
                            @endforeach
                          </tbody>
                      </table>
                    </div>
                    @endif
                  <div class="creditCardForm">
                    <div class="heading">
                      <button class="btn success_btn add_new_card_btn"><i class="fa fa-plus"></i> {{__('dashboard.payment.new_card')}}</button>
                    </div>
                    <hr>
                    <div class="card_form_div d-none">
                      <div class="payment">
                        <form id="general_form" method="post" action="{{url('customer/make-mission-payment')}}">
                          <input type="hidden" name="amount" value="{{Helper::encrypt($mission->amount)}}">
                          @csrf
                          <div class="row">
                            <div class="form-group col-md-8 owner">
                              <label for="owner">{{__('dashboard.payment.holder_name')}}</label>
                              <input type="text" name="name" class="form-control" id="owner" value="" placeholder="Enter card holder's name">
                            </div>
                            <div class="form-group col-md-4 CVV">
                              <label for="cvc">CVC</label>
                              <input type="text" name="cvc" class="form-control" id="cvv" placeholder="Enter CVV number">
                            </div>
                            <div class="form-group col-md-12" id="card-number-field">
                              <label for="cardNumber">{{__('dashboard.payment.card_no')}}</label>
                              <input type="text" maxlength="16" name="card_number" class="form-control" id="cardNumber" value="" placeholder="Enter 16 digits card number">
                            </div>
                            <div class="form-group col-md-3" id="expiration-date">
                              <label>{{__('dashboard.payment.exp_month')}}</label>
                              <div>
                                <select class="form-control" name="expire_month">
                                    <option value="01">January</option>
                                    <option value="02">February </option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group col-md-3" id="expiration-date">
                              <label>{{__('dashboard.payment.exp_year')}}</label>
                              <div>
                                <select class="form-control" name="expire_year">
                                    <option value="20"> 2020</option>
                                    <option value="21"> 2021</option>
                                    <option value="22"> 2022</option>
                                    <option value="23"> 2023</option>
                                    <option value="24"> 2024</option>
                                    <option value="25"> 2025</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group col-md-6 pt-4 text-right" id="credit_cards">
                              <img src="{{asset('assets/payment/images/visa.jpg')}}" id="visa">
                              <img src="{{asset('assets/payment/images/mastercard.jpg')}}" id="mastercard">
                              <img src="{{asset('assets/payment/images/amex.jpg')}}" id="amex">
                            </div>
							<div class="col-md-12">
							  <input type="checkbox" name="save_card_deail" id="save_card_deail" value="1">
							   <label>{{__('dashboard.payment.save_card')}}</label>
							</div>
                          </div>
                          <hr>
                          <div class="col-md-12 text-center">
                              <input type="hidden" name="mission_id" value="{{Helper::encrypt($mission->id)}}">
                              <button type="submit" class="button success_btn">{{__('dashboard.payment.make')}}</button>
                          </div>
                          <!-- <div class="form-group" id="pay-now">
                            <button type="submit" class="btn btn-default" id="confirm-purchase">Confirm</button>
                          </div> -->
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
            <!-- /.col-md-8 -->
        </div>
    </div>
    <!-- /.container -->
</div>
<form id="general_form_2" method="post" action="{{url('customer/make-card-payment')}}">
  @csrf
  <input id="payment_card_id" type="hidden" name="card_id">
  <input type="hidden" name="mission_id" value="{{Helper::encrypt($mission->id)}}">
</form>

<script>
  $(document).ready(function(){
    $(document).on('click','.add_new_card_btn',function(){
      $(document).find('.card_form_div').removeClass('d-none');
    });
	
	$(document).on('click','.add_new_card_btn_pay',function(){
		var expire_month_val = $(this).data('expire_month');
		var expire_month = $. trim($(this).data('expire_month')).split("");
		if(expire_month.length == 1){
			expire_month_val = '0'+expire_month_val;
		}
		$('input[name="name"]').val($(this).data('name'));
		$('input[name="card_number"]').val($(this).data('card_number'));
		$('select[name="expire_month"]').val(expire_month_val);
		$('select[name="expire_year"]').val($(this).data('expire_year'));
		$(document).find('.card_form_div').removeClass('d-none');
    });

    $(document).on('click','.pay_now_btn',function(){
      let card_id = $(this).attr('id');
      $(document).find('#payment_card_id').val(card_id);
      $('#general_form_2').trigger('submit');
    });  
  });
</script>
@endsection