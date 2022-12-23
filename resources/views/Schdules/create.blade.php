@extends('layouts.admin.layout')
<!-- if there are creation errors, they will show here -->
@section('content')
    <div class="panelp panelp-default">
        <div class="panelp-heading">
            <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <div class="pull-left">
                                <h3>Add Schdules ({{$channel->name}})</h3>
                            </div>
                            <div class"pull-right">
                                <a class="pull-right btn btn-default btn-sm m-r-1" href="{{url('/Schdules',$channel->id)}}">
                                    <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
                                </a>        
                                <a href="javascript:;" onclick="submitMe()" class="btn btn-default pull-right btn-sm m-r-1">Save</a>
                            </div>
                            <div class="clearfix"></div>
                            <ol class="breadcrumb">         
                                <li><a href="{{url('/Channels')}}">Channels</a></li>
                                <li><a href="{{url('/Schdules')}}">Schdules</a></li>
                                <li class="active">Add</a>
                            </ol>
                        </div>
                    </div>
                </div>
        </div>
        <div class="panelp-body">
            <header class="section-header">
            </header>

            {{ Html::ul($errors->all()) }}
            {!! Form::open(array('url' => array('/Schdules', $channel->id),'id'=>'add_content','name'=>'add_content','class'=>'form-horizontal')) !!}
                <input type="hidden" name="channel_id" value="{{$channel->id}}" />
                <div class="row">
                <div class="form-group">
                    <label class="col-lg-2 control-label" style="padding-top: 1%; font-weight: bold;">Base Play List</label>
                    <div class="col-lg-10">
                		<select name="playlist_id" class="form-control input-sm">
                			<option value="">--Select Play List--</option>
                		<?php foreach($playListes as $index=>$val){ ?>
                        		<option value="{{$index}}" {{ $index==$channel->play_list ?'selected="selected"':''}}>{{$val}}</option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="form-group">
                    <label class="col-lg-2 control-label" style="padding-top: 1%; font-weight: bold;">Start Time</label>
                    <div class="col-lg-10">
                        {!! Form::text('start_time', Input::old('start_time'), array('class' => 'form-control input-sm','placeholder'=>'Start Time')) !!}
                    </div>
                </div>
                </div>

                <div class="row">    
                <div class="form-group">
                    <label class="col-lg-2 control-label" style="padding-top: 1%; font-weight: bold;">End Time</label>
                    <div class="col-lg-10">
                        {!! Form::text('end_time', Input::old('end_time'), array('id'=>'end_time','class' => 'form-control input-sm','placeholder'=>'End Time')) !!}
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="form-group">
                    <label class="col-lg-2 control-label" style="padding-top: 1%; font-weight: bold;">Duration
                        <input type="checkbox" id="checkField" checked="checked" onclick="enableInput()" value="1"><small>Enable</small>
                    </label>
                    <div class="col-lg-10">
                        {!! Form::text('duration', Input::old('duration'), array('id'=>'duration','disabled'=>'dsiabled','class' => 'form-control input-sm','placeholder'=>'Duration')) !!}
                    </div>
                </div>
                </div>

                <div class="clearfix"></div>
                <div class="form-group" style="margin-top:10px;">                
                    <div class="col-lg-offset-1 col-lg-2" >
                        <a class="pull-right btn btn-danger" href="{{url('/Channels',$channel->id)}}">
                        <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back</a>
                    </div>
                    <div class="col-lg-offset-1">
                        <button type="button" onclick="submitMe()" class="btn btn-primary btn-sm save-btn">Save</button>                    
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{asset('js/jquery.form.js?v=1')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.validate.min.js?v=1')}}"></script>
    <script type="text/javascript">
    function enableInput(){
        if($('#checkField').is(':checked') == 1){
            $('#end_time').prop('disabled',true);
            $('#duration').prop('disabled',false);
        }else{
            $('#duration').prop('disabled',true);
            $('#end_time').prop('disabled',false);
        }
        
    }
    function submitMe(){        
        $('#add_content').submit();
    }
    $(document).ready(function(){
        enableInput();
        options = {
                rules: {
                    "playlist_id": "required",
                    "start_time":"required",
                    "end_time":"required",
                    "duration":'required'
                },
                messages: {
                    "playlist_id": "Please select play list",
                    "start_time":"Start time is required",
                    "end_time":"End time required",
                    "duration":'Duration required'
                }
            };
            
            $('#add_content').validate( options );
    });
    </script>
@endsection