<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
</head>
<style type="text/css">
    body{
        font-family: monospace;
    }
    #invoice{
        padding:0;
    }
    .invoice {
        position: relative;
        background-color: #FFF;
        padding: 15px;
    }

    .invoice header {
        padding: 10px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #3989c6
    }

    .invoice .company-details {
        text-align: right
    }

    .invoice .company-details .name {
        margin-top: 0;
        margin-bottom: 0
    }

    .invoice .contacts {
        margin-bottom: 20px
    }

    .invoice .invoice-to {
        text-align: left
    }

    .invoice .invoice-to .to {
        margin-top: 0;
        margin-bottom: 0
    }

    .invoice .invoice-details {
        text-align: right
    }

    .invoice .invoice-details .invoice-id {
        margin-top: 0;
        color: #fdda42;
    }

    .invoice main {
        padding-bottom: 50px
    }

    .invoice main .thanks {
        margin-top: -100px;
        font-size: 2em;
        margin-bottom: 50px
    }

    .invoice main .notices {
        padding-left: 6px;
        border-left: 6px solid #3989c6
    }

    .invoice main .notices .notice {
        font-size: 1.2em
    }

    .invoice table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px
    }

    .invoice table td,.invoice table th {
        padding: 15px;
        background: #eee;
        border-bottom: 1px solid #fff
    }

    .invoice table th {
        white-space: nowrap;
        font-weight: 600;
    }
    .invoice table td {
        font-size: 12px !important;
    }

    .invoice table td h3 {
        margin: 0;
        font-weight: 400;
        color: #3989c6;
        font-size: 1.2em
    }

    .invoice table .qty,.invoice table .total,.invoice table .unit {
        text-align: right;
        font-size: 1.2em
    }

    .invoice table .no {
        color: #fff;
        font-size: 1.6em;
        background: #3989c6
    }

    .invoice table .unit {
        background: #ddd
    }

    .invoice table .total {
        background: #3989c6;
        color: #fff
    }

    .invoice table tbody tr:last-child td {
        border: none
    }

    .invoice table tfoot td {
        background: 0 0;
        border-bottom: none;
        white-space: nowrap;
        padding: 10px 20px;
        font-size: 1.2em;
        border-top: 1px solid #aaa
    }

    .invoice table tfoot tr:first-child td {
        border-top: none
    }

    .invoice table tfoot tr:last-child td {
        color: #3989c6;
        font-size: 1.4em;
        border-top: 1px solid #3989c6
    }

    .invoice table tfoot tr td:first-child {
        border: none
    }

    .invoice footer {
        width: 100%;
        text-align: center;
        color: #777;
        border-top: 1px solid #aaa;
        padding: 8px 0
    }
    .pull-left{
        float: left;
    }
    .pull-right{
        float: right;
    }
    .clearfix{
        clear: both;
    }
    .text-gray-light{
        font-size: 14px;
        font-weight: 600;
    }
    .text-center{
        text-align: center;
    }
    .text-right{
        text-align: right;
    }
    h1, h2, h3, h4, h5, h6{
        padding: 0;
        margin: 0;
    }
    .header, .main, .footer, table{
        font-size:12px;
    }
	
	* {
  box-sizing: border-box;
}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>
<body>
    <div id="invoice">
        <div class="invoice overflow-auto">
            <div>
                <div class="header">
                    <div class="pull-left">
                        <img height="50px" src='{{ public_path("assets/images/logo.jpg") }}' />
                    </div>
                    <div class="pull-right">
                        <h2 class="name">
                            {{config('app.name')}}
                        </h2>
                        <div>66 Avenue des Champs-Elysées 75008 Paris </div>
                        <div>ID: 882276694 RCS Paris</div>
                        <!-- <div>company@example.com</div> ./../../assets/images/logo.jpg-->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <hr>
                <div class="main">
                    <div class="row contacts">
                        <div class="pull-left invoice-to">
                            <div class="text-gray-light">{{__('dashboard.customer_details')}}:</div>
                            <p class="to">{{$data->first_name}} {{$data->last_name}}</p>
                            <div class="address">{{$data->home_address}}</div>
                            <div class="email"><a href="mailto:{{$email}}">{{$email}}</a></div>
                        </div>
                        <div class="pull-right">
                            <h2 class="invoice-id">REC-000-{{$data->id}}</h2>
                            <div class="date">{{__('dashboard.invoice_date')}}: {{Helper::date_format_show('d/m/Y',date('Y-m-d'))}}</div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                
                <div class="container">
					<div class="row">
					  <div class="col-25">
						<label for="fname">{{__('dashboard.mission.title')}}</label>
					  </div>
					  <div class="col-75">
						<input type="text" id="fname" value="{{$mission->title}}">
					  </div>
					</div>
					<div class="row">
					  <div class="col-25">
						<label for="lname">{{__('dashboard.mission.ref')}}</label>
					  </div>
					  <div class="col-75">
						<input type="text" id="lname" value="{{Helper::mission_id_str($mission->id)}}">
					  </div>
					</div>
					<div class="row">
					  <div class="col-25">
						<label for="lname">{{__('dashboard.mission.location')}}</label>
					  </div>
					  <div class="col-75">
						<input type="text" id="lname" value="{{$mission->location}}">
					  </div>
					</div>
					<div class="row">
					  <div class="col-25">
						<label for="lname">{{__('dashboard.agent_needed')}}</label>
					  </div>
					  <div class="col-75">
						<input type="text" id="lname" value="{{Helper::get_agent_type_name($mission->agent_type)}}">
					  </div>
					</div>
					<div class="row">
					  <div class="col-25">
						<label for="lname">{{__('dashboard.vehicle_required')}}</label>
					  </div>
					  <div class="col-75">
						<input type="text" id="lname" value="{{Helper::vehicle_required_status($mission->vehicle_required)}}">
					  </div>
					</div>
					<div class="row">
					  <div class="col-25">
						<label for="lname">{{__('dashboard.mission.mission_hours')}}</label>
					  </div>
					  <div class="col-75">
						<input type="text" id="lname" value="{{$mission->total_hours}} Hour(s)">
					  </div>
					</div>
					@if($mission->quick_book==0)
					<div class="row">
					  <div class="col-25">
						<label for="lname">{{__('dashboard.mission.start_time')}}</label>
					  </div>
					  <div class="col-75">
						<input type="text" id="lname" value="{{date('d/m/Y H:i:s', strtotime($mission->start_date_time))}}">
					  </div>
					</div>
					@endif
					<div class="row">
					  <div class="col-25">
						<label for="lname">{{__('dashboard.agents.intervention')}}</label>
					  </div>
					  <div class="col-75">
						<input type="text" id="lname" value="{{__('dashboard.agents.'.$mission->intervention.'')}}">
					  </div>
					</div>
					@if($mission->intervention == 'Security_patrol' && isset($mission->repetitive_mission) && isset($mission->mission_finish_time) && !empty($mission->repetitive_mission) && !empty($mission->mission_finish_time))
					  <div class="row">
					  <div class="col-25">
						<label for="lname">{{__('dashboard.agents.repetitive_mission')}}</label>
					  </div>
					  <div class="col-75">
						<input type="text" id="lname" value="{{$mission->repetitive_mission}}">
					  </div>
					</div>
					<div class="row">
					  <div class="col-25">
						<label for="lname">{{__('dashboard.agents.finish_time')}}</label>
					  </div>
					  <div class="col-75">
						<input type="text" id="lname" value="{{$mission->mission_finish_time}}">
					  </div>
					</div>
					<div class="row">
					  <div class="col-25">
						<label for="lname">{{__('dashboard.agents.time_intervel')}}</label>
					  </div>
					  <div class="col-75">
						<input type="text" id="lname" value="{{$mission->time_intervel}}">
					  </div>
					</div>
					@endif
					<div class="row">
					  <div class="col-25">
						<label for="lname">{{__('dashboard.mission.description')}}</label>
					  </div>
					  <div class="col-75">
						<input type="text" id="lname" value="{{$mission->description}}">
					  </div>
					</div>
					@if(isset($mission->agent_details))
						<br /><br /><br />
						<h3>{{__('dashboard.agents.details')}}</h3>
						<br />
					<div class="row">
					  <div class="col-25">
						<label for="lname">{{__('dashboard.agents.name')}}</label>
					  </div>
					  <div class="col-75">
						<input type="text" id="lname" value="{{ucfirst($mission->agent_details->username)}}">
					  </div>
					</div>
					<div class="row">
					  <div class="col-25">
						<label for="lname">{{__('dashboard.agents.type')}}</label>
					  </div>
					  <div class="col-75">
						<input type="text" id="lname" value="{{Helper::get_agent_type_name_multiple($mission->agent_details->types)}}">
					  </div>
					</div>
					@endif
					<br /><br /><br />
						<h3>{{__('dashboard.payment.details')}}</h3>
					<br />
					@php 
					  $vat_amount = Helper::get_vat_amount($mission->amount,$mission->vat);
					  $original_amount = $mission->amount-$vat_amount;
					@endphp
					
					<div class="table">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td class="text-center">{{__('dashboard.payment.total')}}:</td>
                                <td class="text-right">{{$original_amount}} €</td>
                            </tr>
							<tr>
                                <td class="text-center">{{__('dashboard.vat')}} ({{Helper::VAT_PERCENTAGE}}%)</td>
                                <td class="text-right">{{$vat_amount}} €</td>
                            </tr>
							<tr>
                                <td class="text-center">{{__('dashboard.payment.total_mission_amount')}}</td>
                                <td class="text-right">{{$mission->amount}} €</td>
                            </tr>
							@if($mission->quick_book==0)
							<tr>
                                <td class="text-center">{{__('dashboard.payment.total_charge_amount')}}</td>
                                <td class="text-right">{{$charge_amount}} €</td>
                            </tr>
							@endif
                        </tbody>
                       
                    </table>
				</div>
                <hr>
                <div class="footer text-center">
                    <p>{!!__('dashboard.pdf_copyright')!!}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>