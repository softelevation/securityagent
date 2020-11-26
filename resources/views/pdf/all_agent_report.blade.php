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
                        <div>Be On Time SAS 13 rue Washington</div>
                        <div>75008 Paris 01 83 62 52 14</div>
                        <div>contact@ontimebe.com</div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <hr>
                
                <div class="table">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th class="text-center">{{__('dashboard.mission.mission_id')}}</th>
                                <th class="text-center">{{__('dashboard.mission.title')}}</th>
                                <th class="text-center">{{__('dashboard.agent')}}</th>
                                <th class="text-center">{{__('dashboard.customer_name')}}</th>
                                <th class="text-right">{{__('dashboard.agents.time_intervel')}}</th>
                                <th class="text-right">{{__('dashboard.amount')}}</th>
								<th class="text-right">{{__('dashboard.mission.location')}}</th>
                            </tr>
                        </thead>
                        <tbody>
						@php $original_amount= 0; $total_hours_sum = 0; @endphp
							@foreach($results as $result)
                            <tr>
                                <td class="text-center">{{Helper::mission_id_str($result->id)}}</td>
                                <td class="text-center">{{ $result->title }}</td>
                                <td class="text-center">{{ucfirst($result->agent_details->first_name.' '.$result->agent_details->last_name)}}</td>
                                <td class="text-center">{{ucfirst($result->customer_details->first_name.' '.$result->customer_details->last_name)}}</td>
                                <td class="text-right">{{ $result->total_hours }} {{__('dashboard.hours')}}</td>
                                <td class="text-right">{{ $result->amount }} €</td>
								<td class="text-right">{{ $result->location }}</td>
                            </tr>
							@php 
							  $original_amount+= $result->amount;
							  $total_hours_sum+= $result->total_hours;
							@endphp
				
							@endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="5">{{__('dashboard.agents.total_hours_worked')}} {{$total_hours_sum}} {{__('dashboard.hours')}}</td>
                                <td class="text-right">{{__('dashboard.grand_total')}} {{$original_amount}} €</td>
                            </tr>
                        </tfoot>
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