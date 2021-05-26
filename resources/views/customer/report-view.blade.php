@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('frontend.text_155')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-100">
                          <a id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link active">{{__('frontend.text_155')}}</a>
                      </li>
                  </ul>
                  <div class="tab-content" id="nav-tabContent">
					<div class="pending-details view_agent_details mt-4">
						<div class="table-responsive">
							<table class="table table-hover table-striped">
								<tbody>
									<tr>
										<td>{{Form::checkbox('intervention',1,($mission->report->intervention) ? true:false)}} <label>INTERVENTION</label></td>
									</tr>
								</tbody>
							</table>
							<div class="row">
								<div class="col-md-4 form-group">
								  <label>Date</label>
								<span class="form-control">{{ date("d-m-Y",strtotime($mission->report->date)) }}</span>
								</div>
								<div class="col-md-2 form-group">
								</div>
								<!-- div class="col-md-4 form-group">
									<label>Identifiant du rapport</label>
									<span class="form-control"></span>
								</div -->
							</div>
							<table class="table table-hover table-striped">
								<tbody>
									<tr>
										<td><label>HEURE APPEL :</label> <span class="form-control">{{$mission->report->heure_appel}}</span></td>
										<td><label>HEURE ARRIVEE :</label> <span class="form-control">{{$mission->report->heure_arivve}}</span></td>
										<td><label>HEURE DE DEPART :</label> <span class="form-control">{{$mission->report->heure_de_depart}}</span></td>
									</tr>
								</tbody>
							</table>
							<table class="table table-hover table-striped">
								<tbody>
									<tr>
										<td>Constat météo</td>
										<td>
											{{$mission->report->constat_meteo}}
										</td>
									</tr>
									<tr>
										<td>Circulation</td>
										<td>
											{{$mission->report->circulation}}
										</td>
									</tr>
									<tr>
										<td>Circuit de Vérification</td>
										<td>
											{{$mission->report->circuit_de_verification}}
										</td>
									</tr>
									<tr>
										<td>Lumière allumée</td>
										<td>
											{{$mission->report->lumiere_allumee}}
										</td>
									</tr>
									<tr>
										<td>Issues(s) ouvertes(s)</td>
										<td>
											{{$mission->report->issues_ouvertes}}
										</td>
									</tr>
									<tr>
										<td>Sirène en fonction</td>
										<td>
											{{$mission->report->sirene_en_fonction}}
										</td>
									</tr>
									<tr>
										<td>Système</td>
										<td>
											{{$mission->report->systeme}}
										</td>
									</tr>
									<tr>
										<td>Remise en service du système</td>
										<td>
											{{$mission->report->remise_en_service_du_systeme}}
										</td>
									</tr>
									<tr>
										<td>Effraction constatée</td>
										<td>
											{{$mission->report->effraction_constatee}}
										</td>
									</tr>
									<tr>
										<td>{{__('dashboard.comments')}}</td>
										<td>
											<span>{{$mission->report->description}}</span>
										</td>
									</tr>
									@if($mission->report->signature)
									<tr>
										<td>{{__('dashboard.report.signature')}}</td>
										<td>
											<div class="profile_img">
												<img src="{{ Helper::api_url($mission->report->signature) }}" class="img-fluid" style="width: 260px;">
											</div>
										</td>
									</tr>
									@endIf
								</tbody>
							</table>
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
@endsection