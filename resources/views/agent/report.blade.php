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
									</tr>
								</tbody>
							</table>
							<div class="row">
								<div class="col-md-4 form-group">
								  Date {{Form::text('date',(isset($newFeature['date'])) ? date("d-m-Y", strtotime($newFeature['date'])) : null,['class'=>'form-control reportdatepicker'])}}
								</div>
							</div>
							<table class="table table-hover table-striped">
								<tbody>
									<tr>
										<td><label>HEURE APPEL :</label> {{Form::text('heure_appel',null,['class'=>'form-control timepicker'])}}</td>
										<td><label>HEURE ARRIVEE :</label> {{Form::text('heure_arivve',null,['class'=>'form-control timepicker'])}}</td>
										<td><label>HEURE DE DEPART :</label> {{Form::text('heure_de_depart',null,['class'=>'form-control timepicker'])}}</td>
									</tr>
								</tbody>
							</table>
							<table class="table table-hover table-striped">
								<tbody>
									<tr>
										<td>Constat météo</td>
										<td>
											{{Form::checkbox('constat_meteo	',1,false)}}
										</td>
									</tr>
									<tr>
										<td>Circulation</td>
										<td>
											{{Form::text('circulation',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Circuit de Vérification</td>
										<td>
											{{Form::text('circuit_de_verification',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Lumière allumée</td>
										<td>
											{{Form::text('lumiere_allumee',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Issues(s) ouvertes(s)</td>
										<td>
											{{Form::text('issues_ouvertes',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Sirène en fonction</td>
										<td>
											{{Form::text('sirene_en_fonction',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Système</td>
										<td>
											{{Form::text('systeme',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Remise en service du système</td>
										<td>
										{{Form::text('remise_en_service_du_systeme',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>Effraction constatée</td>
										<td>
										{{Form::text('effraction_constatee',null,['class'=>'col-md-2'])}}
										</td>
									</tr>
									<tr>
										<td>{{__('dashboard.comments')}}</td>
										<td>
											{{Form::text('description',null,['class'=>'form-control'])}} 
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