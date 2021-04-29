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
        margin-bottom: 2px
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
        padding: 2px 20px;
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
                <div class="main">
                    <div class="row contacts">
                        <div class="pull-left invoice-to">
                            <div class="text-gray-light">{{__('dashboard.customer_details')}}:</div>
                            <p class="to">{{$profile->first_name}} {{$profile->last_name}}</p>
                            <div class="address">{{$profile->home_address}}</div>
                            <div class="email"><a href="mailto:{{$profile->email}}">{{$profile->email}}</a></div>
                        </div>
                        <div class="pull-right">
                            <h2 class="invoice-id">REC-000-{{$data->id}}</h2>
                            <div class="date">{{__('dashboard.invoice_date')}}: {{Helper::date_format_show('d/m/Y',$data->created_at)}}</div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                @php 
                  $vat_amount = Helper::get_vat_amount($data->amount,$data->vat);
                  $original_amount = $data->amount-$vat_amount;
                @endphp
                <div class="table">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th class="text-center">{{__('dashboard.mission.ref')}}</th>
                                <th class="text-center">{{__('dashboard.mission.title')}}</th>
                                <th class="text-center">{{__('dashboard.mission.description')}}</th>
                                <th class="text-center">{{__('dashboard.status')}}</th>
                                <th class="text-right">{{__('dashboard.amount')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{Helper::mission_id_str($data->id)}}</td>
                                <td class="text-center">{{strtoupper($data->title)}}</td>
                                <td class="text-center">@if($data->quick_book==1) {{__('dashboard.quick_booking')}} @else {{__('dashboard.future_booking')}} @endif</td>
                                <td class="text-center">@if($data->payments->status == 'succeeded') {{__("frontend.succeeded")}} @else {{ $data->payments->status }}  @endif</td>
                                <td class="text-right">{{$original_amount}} &euro;</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="4">{{__('dashboard.vat')}} ({{$data->vat}}%)</td>
                                <td class="text-right">{{$vat_amount}} &euro;</td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="4">{{__('dashboard.grand_total')}}</td>
                                <td class="text-right">{{$data->amount}} &euro;</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <hr>
				<div class="footer">
                    <p>T.V.A payée sur les encaissements.</p>
                    <p>Conformément à l’article L.441-6 du Code du Commerce, des pénalités de retard sont dues à défaut de règlement le jour suivant la date de paiement qui figure sur la facture.</p>
                    <p>Le taux d’intérêt de ces pénalités de retard est de 12,50% annuels.</p>
                    <p>Conformément au décret n°2012-1115 du 2 octobre 2012, une indemnité forfaitaire pour frais de recouvrement fixée à 40 € sera également due en cas de retard de paiement.</p>
					<p>Autorisation exercée au numéro CNAPS AUT-075-2119-06-05-20200741467</p>
				</div>
				<div class="footer text-center">
                    <b>SIRET 882 276 694 00024 APE 8020Z</b>
                </div>
                <div class="footer text-center">
                    <p>{!!__('dashboard.pdf_copyright')!!}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>