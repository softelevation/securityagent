@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.agent_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>Schedule</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="agent_schedule"></div>
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
<!-- Modal -->
<div id="schedule_model" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Agent Schedule (<span></span>)</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      {{Form::open(['url'=>url('agent/save-schedule'),'id'=>'general_form'])}}
      {{form::hidden('schedule_date',null,['id'=>'schedule_date'])}}
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 form-group">
            <label>Available From</label>
            {{Form::text('available_from',null,['class'=>'form-control timepicker','placeholder'=>'Set availability from time','id'=>'available_from'])}}
          </div>
          <div class="col-md-6 form-group">
            <label>Available To</label>
            {{Form::text('available_to',null,['class'=>'form-control timepicker', 'placeholder'=>'Set availability to time','id'=>'available_to'])}}
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary success_btn">Save Schedule</button>
        <button type="button" class="btn btn-secondary danger_btn"  data-dismiss="modal">Close</button>
      </div>
      {{Form::close()}}
    </div>
  </div>
</div>
<script type="text/javascript">
  var schedule = JSON.parse('@php echo $schedule; @endphp');
</script>
@endsection