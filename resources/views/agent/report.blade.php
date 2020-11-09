@extends('layouts.dashboard')
@section('content')
<link rel="stylesheet" type="text/css" href="./../../assets/signature/css/jquery.signature.css">
<style>
	.kbw-signature { width: 400px; height: 200px;}
	#sig canvas{
		width: 100% !important;
		height: auto;
	}
</style>
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.agent_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>COMPTE RENDU</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-100">
                          <a id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link active">COMPTE RENDU </a>
                      </li>
                     
                  </ul>
                  <div class="tab-content" id="nav-tabContent">
					<div class="pending-details view_agent_details mt-4">
						<div class="table-responsive">
							{{Form::model($newFeature,['url'=>'agent/report/'.$mission_id,'id'=>'general_form'])}}
							@csrf
							<table class="table table-hover table-striped">
								<tbody>
									<tr>
										<td>{{Form::checkbox('intervention',1,false)}} <label>INTERVENTION</label></td>
										<td>{{Form::checkbox('ronde',1,false)}} <label>RONDE</label></td>
										<td>{{Form::checkbox('gardiennage',1,false)}} <label>GARDIENNAGE</label></td>
										<td><label>AVEC MOYEN D’ACCES</label> {{Form::checkbox('oui',1,false)}} <label>OUI</label></td>
										<td>{{Form::checkbox('non',1,false)}}  <label>NON</label></td>
									</tr>
								</tbody>
							</table>
							<div class="row">
								<div class="col-md-4 form-group">
								  Date {{Form::text('date',(isset($newFeature['date'])) ? date("d-m-Y", strtotime($newFeature['date'])) : null,['class'=>'form-control reportdatepicker'])}}
								</div>
								<div class="col-md-2 form-group">
								</div>
								<div class="col-md-4 form-group">
								  Identifiant du rapport 
								  <span class="form-control">{{ $report_id }}</span>
								  {{Form::hidden('report_id',$report_id)}}
								</div>
							</div>
							<table class="table table-hover table-striped">
								<tbody>
									<tr>
										<td><label>HEURE APPEL :</label> {{Form::text('heure_appel',null,['class'=>'form-control timepicker'])}}</td>
										<td><label>HEURE ARRIVEE :</label> {{Form::text('heure_arrivee',null,['class'=>'form-control timepicker'])}}</td>
										<td><label>HEURE DE DEPART :</label> {{Form::text('heure_de_depart',null,['class'=>'form-control timepicker'])}}</td>
									</tr>
								</tbody>
							</table>
							<table class="table table-hover table-striped">
								<tbody>
									<tr>
										<td>Constat météo</td>
										<td>
											{{Form::checkbox('vent_fort_01',1,false)}} 01 Vent fort
											{{Form::checkbox('pluie',1,false)}} 02 Pluie
											{{Form::checkbox('orage',1,false)}} 03 Orage
											{{Form::checkbox('neige',1,false)}} 05 Neige
										</td>
									</tr>
									<tr>
										<td>Circulation</td>
										<td>
											{{Form::checkbox('mauvaise',1,false)}} 06. Mauvaise (motif) : {{Form::text('mauvaise_text',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Circuit de Vérification</td>
										<td>
											{{Form::checkbox('interieur',1,false)}} 07 Intérieur
											{{Form::checkbox('exterieur',1,false)}} 08 Extérieur : {{Form::text('exterieur_text',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Lumière allumée</td>
										<td>
											{{Form::checkbox('non_09',1,false)}} 09 Non
											{{Form::checkbox('oui_pièce',1,false)}} 10 Oui Pièce : {{Form::text('oui_pièce_text',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Issues(s) ouvertes(s)</td>
										<td>
											{{Form::checkbox('non_11',1,false)}} 11 Non
											{{Form::checkbox('oui_lesquelles_12',1,false)}} 12 Oui Lesquelles : {{Form::text('oui_lesquelles_text',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Sirène en fonction</td>
										<td>
											{{Form::checkbox('non_13',1,false)}} 13 Non
											{{Form::checkbox('oui_14',1,false)}} 14 Oui
										</td>
									</tr>
									<tr>
										<td>Système</td>
										<td>
											{{Form::checkbox('en_service_15',1,false)}} 15 En service
											{{Form::checkbox('hors_service_16',1,false)}} 16 Hors service à l’arrivée de l’intervenant
										</td>
									</tr>
									<tr>
										<td>Remise en service du système</td>
										<td>
											{{Form::checkbox('non_17',1,false)}} 17 Non
											{{Form::checkbox('oui_18',1,false)}} 18 Oui
										</td>
									</tr>
									<tr>
										<td>{{Form::checkbox('zone_19',1,false)}} 19 Zone(s) en anomalies</td>
										<td>
											{{Form::checkbox('zones_isolees',1,false)}} 20 Zones isolées : {{Form::text('zones_isolees_text',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Effraction constatée</td>
										<td>
											{{Form::checkbox('non_21',1,false)}} 21 Non
											{{Form::checkbox('oui_22',1,false)}} 22 Oui
										</td>
									</tr>
									<tr>
										<td>Présence</td>
										<td>
											{{Form::checkbox('client_23',1,false)}} 23 Client
											{{Form::checkbox('police_24',1,false)}} 24 Police
											{{Form::checkbox('gendarmerie_25',1,false)}} 25 Gendarmerie
											{{Form::checkbox('pompiers_26',1,false)}} 26 Pompiers
										</td>
									</tr>
									<tr>
										<td>Présence</td>
										<td>
											{{Form::checkbox('ads_27',1,false)}} 27 ADS
											{{Form::checkbox('demande_par',1,false)}} Demandé par : {{Form::text('demande_par_text',null,['class'=>'col-md-2'])}}
											{{Form::checkbox('maitre_chien',1,false)}} 28 Maitre Chien : {{Form::text('maitre_chien_text',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Personnel sur place</td>
										<td>
											{{Form::checkbox('non_29',1,false)}} 29 Non
											{{Form::checkbox('oui_30',1,false)}} 30 Oui Nom : {{Form::text('oui_30_text',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Véhicule sur place</td>
										<td>
											{{Form::checkbox('non_31',1,false)}} 31 Non
											{{Form::checkbox('oui_32',1,false)}} 32 Oui   Marque  : {{Form::text('oui_32_text',null,['class'=>'col-md-2'])}}
											N - {{Form::text('n_0',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Présence d’animaux</td>
										<td>
											{{Form::checkbox('non_33',1,false)}} 33 Non
											{{Form::checkbox('oui_34',1, false)}} 34 Oui  Espèce : {{Form::text('oui_34_text',null,['class'=>'col-md-2'])}} 
										</td>
									</tr>
									<tr>
										<td>{{__('dashboard.comments')}}</td>
										<td>
											{{Form::text('comments',null,['class'=>'form-control'])}} 
										</td>
									</tr>
									<tr>
										<td colspan="2" align="center"><button type="submit" class="button success_btn" data-toggle="modal" data-target="#myModal">valider le rapport</button></td>
									</tr>
								</tbody>
							</table>
							{{Form::close()}}
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
	
	
	<!-- Modal -->
	<div id="myModal" class="modal" role="dialog" data-backdrop="false">
	  <div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">        
			<h4 class="modal-title">{{__('dashboard.report.signature')}}</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>
		  {{Form::model(null,['url'=>'agent/signature/'.$mission_id,'id'=>'general_form_2'])}}
			@csrf
			  <div class="modal-body">
				<div class="container">
						<div class="col-md-12">
							<label class="" for="">{{__('dashboard.report.signature')}}:</label>
							<br/>
							<div id="sig" ></div>
							<p class="text-danger">* {{__('dashboard.report.signature_mandatory')}}.</p>
							<button class="btn btn-success" id="clear">{{__('dashboard.report.clear_signature')}}</button>
							<textarea id="signature64" name="signature" style="display: none"></textarea>
						</div>
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="submit" class="btn btn-primary success_btn">{{__('dashboard.report.save')}}</button>
			  </div>
		  {{Form::close()}}
		</div>
	  </div>
	</div>

</div>

@endsection


@section('script')

<script type="text/javascript" src="./../../assets/signature/js/jquery.signature.js"></script>
<script>
	var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
		$('#clear').click(function(e) {
			e.preventDefault();
			sig.signature('clear');
			$("#signature64").val('');
		});
</script>
@endsection