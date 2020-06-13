<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

@extends('layouts.dashboard')
@section('content')

<div class="profile">
    <div class="container"> 
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9"> 
              <div class="float-left">
                  <h2>English</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent"> 
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                  <div class="tab-content" id="nav-tabContent">
                    <!-- All Missions -->
                    
                    <!-- Missions in progress tab -->
                      <div class="pending-details">
                        <div class="view_agent_details mt-4">

                        <form id="MyForm1" class="form-horizontal" method="post">    
                        {{ csrf_field() }}                      
                            <div class="form-group">
                                <label for="inputDetail" class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="heading" id="heading" value="{{isset($res_data->heading)?$res_data->heading:''}}">
                                        {{isset($res_data->heading)?$res_data->heading:''}}
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputDetail" class="col-sm-3 control-label">Details 1</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="desc" value="{{isset($res_data->desc)?$res_data->desc:''}}">
                                        {{isset($res_data->desc)?$res_data->desc:''}}
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputDetail" class="col-sm-3 control-label">Details 2</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="desc1" value="{{isset($res_data->desc1)?$res_data->desc1:''}}">
                                        {{isset($res_data->desc1)?$res_data->desc1:''}}
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputDetail" class="col-sm-3 control-label">Details 3</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="desc2" value="{{isset($res_data->desc2)?$res_data->desc2:''}}">
                                        {{isset($res_data->desc2)?$res_data->desc2:''}}
                                    </textarea>
                                </div>
                            </div>
 
                            <div class="form-group">
                                <label for="inputDetail" class="col-sm-3 control-label">Details 3</label>
                                <div class="col-sm-9">
                                    <select name="type" class="form-control">
                                        <option <?php echo (isset($res_dat->type) && $res_data->type==1)? 'selected':''; ?>  value="1">English</option>
                                        <!-- <option <?php echo (isset($res_data->type) &&  $res_data->type==2)? 'selected':''; ?>  value="2">France</option> -->
                                    </select>                         
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary" >
                        </form>
                       
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
