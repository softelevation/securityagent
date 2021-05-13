@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
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
										<td>{{Form::checkbox('intervention',1,($feature->report->intervention) ? true:false)}} <label>INTERVENTION</label></td>
									</tr>
								</tbody>
							</table>
							<div class="row">
								<div class="col-md-4 form-group">
								  <label>Date</label>
								<span class="form-control">{{ date("d-m-Y",strtotime($feature->report->date)) }}</span>
								</div>
								<div class="col-md-2 form-group">
								</div>
								<div class="col-md-4 form-group">
									<label>Identifiant du rapport</label>
									<span class="form-control">{{$feature->report->id}}</span>
								</div>
							</div>
							<table class="table table-hover table-striped">
								<tbody>
									<tr>
										<td><label>HEURE APPEL :</label> <span class="form-control">{{$feature->report->heure_appel}}</span></td>
										<td><label>HEURE ARRIVEE :</label> <span class="form-control">{{$feature->report->heure_arivve}}</span></td>
										<td><label>HEURE DE DEPART :</label> <span class="form-control">{{$feature->report->heure_de_depart}}</span></td>
									</tr>
								</tbody>
							</table>
							<table class="table table-hover table-striped">
								<tbody>
									
									@if($feature->report->signature)
									<tr>
										<td>{{__('dashboard.report.signature')}}</td>
										<td>
											<div class="profile_img">
												<img src="{{ Helper::api_url($feature->report->signature) }}" class="img-fluid">
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