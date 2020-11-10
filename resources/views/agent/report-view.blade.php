@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.agent_sidebar')
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
										<td>{{Form::checkbox('intervention',1,($feature->intervention) ? true:false)}} <label>INTERVENTION</label></td>
										<td>{{Form::checkbox('ronde',1,($feature->ronde) ? true:false)}} <label>RONDE</label></td>
										<td>{{Form::checkbox('gardiennage',1,($feature->gardiennage) ? true:false)}} <label>GARDIENNAGE</label></td>
										<td><label>AVEC MOYEN D’ACCES</label> {{Form::checkbox('oui',1,($feature->oui) ? true:false)}} <label>OUI</label></td>
										<td>{{Form::checkbox('non',1,($feature->non) ? true:false)}}  <label>NON</label></td>
									</tr>
								</tbody>
							</table>
							<div class="row">
								<div class="col-md-4 form-group">
								  <label>Date</label>
								  <span class="form-control">{{ date("d-m-Y",strtotime($feature->date)) }}</span>
								</div>
								<div class="col-md-2 form-group">
								</div>
								<div class="col-md-4 form-group">
								  <label>Identifiant du rapport</label>
								  <span class="form-control">{{$feature->report_id}}</span>
								</div>
							</div>
							<table class="table table-hover table-striped">
								<tbody>
									<tr>
										<td><label>HEURE APPEL :</label> <span class="form-control">{{$feature->heure_appel}}</span></td>
										<td><label>HEURE ARRIVEE :</label> <span class="form-control">{{$feature->heure_arrivee}}</span></td>
										<td><label>HEURE DE DEPART :</label> <span class="form-control">{{$feature->heure_de_depart}}</span></td>
									</tr>
								</tbody>
							</table>
							<table class="table table-hover table-striped">
								<tbody>
									<tr>
										<td>Constat météo</td>
										<td>
											{{Form::checkbox('vent_fort_01',1,($feature->vent_fort_01) ? true:false)}} 01 Vent fort
											{{Form::checkbox('pluie',1,($feature->pluie) ? true:false)}} 02 Pluie
											{{Form::checkbox('orage',1,($feature->orage) ? true:false)}} 03 Orage
											{{Form::checkbox('neige',1,($feature->neige) ? true:false)}} 05 Neige
										</td>
									</tr>
									<tr>
										<td>Circulation</td>
										<td>
											{{Form::checkbox('mauvaise',1,($feature->mauvaise) ? true:false)}} 06. Mauvaise (motif) : {{$feature->mauvaise_text}}
										</td>
									</tr>
									<tr>
										<td>Circuit de Vérification</td>
										<td>
											{{Form::checkbox('interieur',1,($feature->interieur) ? true:false)}} 07 Intérieur
											{{Form::checkbox('exterieur',1,($feature->exterieur) ? true:false)}} 08 Extérieur : {{$feature->exterieur_text}}
										</td>
									</tr>
									<tr>
										<td>Lumière allumée</td>
										<td>
											{{Form::checkbox('non_09',1,($feature->non_09) ? true:false)}} 09 Non
											{{Form::checkbox('oui_pièce',1,($feature->oui_pièce) ? true:false)}} 10 Oui Pièce : {{$feature->oui_pièce_text}}
										</td>
									</tr>
									<tr>
										<td>Issues(s) ouvertes(s)</td>
										<td>
											{{Form::checkbox('non_11',1,($feature->non_11) ? true:false)}} 11 Non
											{{Form::checkbox('oui_lesquelles_12',1,($feature->oui_lesquelles_12) ? true:false)}} 12 Oui Lesquelles : {{$feature->oui_lesquelles_text}}
										</td>
									</tr>
									<tr>
										<td>Sirène en fonction</td>
										<td>
											{{Form::checkbox('non_13',1,($feature->non_13) ? true:false)}} 13 Non
											{{Form::checkbox('oui_14',1,($feature->oui_14) ? true:false)}} 14 Oui
										</td>
									</tr>
									<tr>
										<td>Système</td>
										<td>
											{{Form::checkbox('en_service_15',1,($feature->en_service_15) ? true:false)}} 15 En service
											{{Form::checkbox('hors_service_16',1,($feature->hors_service_16) ? true:false)}} 16 Hors service à l’arrivée de l’intervenant
										</td>
									</tr>
									<tr>
										<td>Remise en service du système</td>
										<td>
											{{Form::checkbox('non_17',1,($feature->non_17) ? true:false)}} 17 Non
											{{Form::checkbox('oui_18',1,($feature->oui_18) ? true:false)}} 18 Oui
										</td>
									</tr>
									<tr>
										<td>{{Form::checkbox('zone_19',1,($feature->zone_19) ? true:false)}} 19 Zone(s) en anomalies</td>
										<td>
											{{Form::checkbox('zones_isolees',1,($feature->zones_isolees) ? true:false)}} 20 Zones isolées : {{$feature->zones_isolees_text}}
										</td>
									</tr>
									<tr>
										<td>Effraction constatée</td>
										<td>
											{{Form::checkbox('non_21',1,($feature->non_21) ? true:false)}} 21 Non
											{{Form::checkbox('oui_22',1,($feature->oui_22) ? true:false)}} 22 Oui
										</td>
									</tr>
									<tr>
										<td>Présence</td>
										<td>
											{{Form::checkbox('client_23',1,($feature->client_23) ? true:false)}} 23 Client
											{{Form::checkbox('police_24',1,($feature->police_24) ? true:false)}} 24 Police
											{{Form::checkbox('gendarmerie_25',1,($feature->gendarmerie_25) ? true:false)}} 25 Gendarmerie
											{{Form::checkbox('pompiers_26',1,($feature->pompiers_26) ? true:false)}} 26 Pompiers
										</td>
									</tr>
									<tr>
										<td>Présence</td>
										<td>
											{{Form::checkbox('ads_27',1,($feature->ads_27) ? true:false)}} 27 ADS
											{{Form::checkbox('demande_par',1,($feature->demande_par) ? true:false)}} Demandé par : {{$feature->demande_par_text}}
											{{Form::checkbox('maitre_chien',1,($feature->maitre_chien) ? true:false)}} 28 Maitre Chien : {{$feature->maitre_chien_text}}
										</td>
									</tr>
									<tr>
										<td>Personnel sur place</td>
										<td>
											{{Form::checkbox('non_29',1,($feature->non_29) ? true:false)}} 29 Non
											{{Form::checkbox('oui_30',1,($feature->oui_30) ? true:false)}} 30 Oui Nom : {{$feature->oui_30_text}}
										</td>
									</tr>
									<tr>
										<td>Véhicule sur place</td>
										<td>
											{{Form::checkbox('non_31',1,($feature->non_31) ? true:false)}} 31 Non
											{{Form::checkbox('oui_32',1,($feature->oui_32) ? true:false)}} 32 Oui Marque  : {{$feature->oui_32_text}}
											N - <span>{{$feature->n_0}}</span>
										</td>
									</tr>
									<tr>
										<td>Présence d’animaux</td>
										<td>
											{{Form::checkbox('non_33',1,($feature->non_33) ? true:false)}} 33 Non
											{{Form::checkbox('oui_34',1, ($feature->oui_34) ? true:false)}} 34 Oui  Espèce : {{$feature->oui_34_text}} 
										</td>
									</tr>
									<tr>
										<td>{{__('dashboard.comments')}}</td>
										<td>
											<span>{{ $feature->comments }}</span>
										</td>
									</tr>
									@if($feature->signature)
									<tr>
										<td>{{__('dashboard.report.signature')}}</td>
										<td>
											<div class="profile_img">
												<img src="{{url('agent/signature/'.$feature->signature)}}" class="img-fluid">
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