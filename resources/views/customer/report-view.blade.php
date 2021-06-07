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
										<td>{{Form::checkbox('intervention',1,($report->intervention) ? true:false)}} <label>INTERVENTION</label></td>
									</tr>
								</tbody>
							</table>
							<div class="row">
								<div class="col-md-4 form-group">
								  <label>Date</label>
								<span class="form-control">{{ isset($report->date) ? date("d-m-Y",strtotime($report->date)) : 'N/A' }}</span>
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
										<td><label>HEURE APPEL :</label> <span class="form-control">{{isset($report->heure_appel) ? $report->heure_appel : 'N/A'}}</span></td>
										<td><label>HEURE ARRIVEE :</label> <span class="form-control">{{isset($report->heure_arivve) ? $report->heure_arivve : 'N/A'}}</span></td>
										<td><label>HEURE DE DEPART :</label> <span class="form-control">{{isset($report->heure_de_depart) ? $report->heure_de_depart : 'N/A'}}</span></td>
									</tr>
								</tbody>
							</table>
							<table class="table table-hover table-striped">
								<tbody>
									<tr>
										<td>Constat météo</td>
										<td>
											{{isset($report->constat_meteo) ? $report->constat_meteo : 'N/A'}}
										</td>
									</tr>
									<tr>
										<td>Circulation</td>
										<td>
											{{isset($report->circulation) ? $report->circulation : 'N/A'}}
										</td>
									</tr>
									<tr>
										<td>Circuit de Vérification</td>
										<td>
											{{isset($report->circuit_de_verification) ? $report->circuit_de_verification : 'N/A'}}
										</td>
									</tr>
									<tr>
										<td>Lumière allumée</td>
										<td>
											{{isset($report->lumiere_allumee) ? $report->lumiere_allumee : 'N/A'}}
										</td>
									</tr>
									<tr>
										<td>Issues(s) ouvertes(s)</td>
										<td>
											{{isset($report->issues_ouvertes) ? $report->issues_ouvertes : 'N/A'}}
										</td>
									</tr>
									<tr>
										<td>Sirène en fonction</td>
										<td>
											{{isset($report->sirene_en_fonction) ? $report->sirene_en_fonction : 'N/A'}}
										</td>
									</tr>
									<tr>
										<td>Système</td>
										<td>
											{{isset($report->systeme) ? $report->systeme : 'N/A'}}
										</td>
									</tr>
									<tr>
										<td>Remise en service du système</td>
										<td>
											{{isset($report->remise_en_service_du_systeme) ? $report->remise_en_service_du_systeme : 'N/A'}}
										</td>
									</tr>
									<tr>
										<td>Effraction constatée</td>
										<td>
											{{isset($report->effraction_constatee) ? $report->effraction_constatee : 'N/A'}}
										</td>
									</tr>
									<tr>
										<td>{{__('dashboard.comments')}}</td>
										<td>
											<span>{{isset($report->description) ? $report->description : 'N/A'}}</span>
										</td>
									</tr>
									@if(isset($report->signature) && $report->signature)
									<tr>
										<td>{{__('dashboard.report.signature')}}</td>
										<td>
											<div class="profile_img">
												<img src="{{ Helper::api_url($report->signature) }}" class="img-fluid" style="width: 260px;">
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