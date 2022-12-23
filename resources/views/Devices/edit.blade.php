@extends('layouts.admin.layout')
<!-- if there are creation errors, they will show here -->
@section('content')
    <div class="panelp panelp-default">
        <div class="panelp-heading">
            <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <div class="pull-left">
                                <h3> Edit Devices</h3>
                            </div>
                            <div class"pull-right">
                                <a class="pull-right btn btn-default btn-sm m-r-1" href="{{url('/Devices')}}">
                                    <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
                                </a>        
                                <a href="javascript:;" onclick="submitMe()" class="btn btn-default pull-right btn-sm m-r-1">Save</a>
                            </div>
                            <div class="clearfix"></div>
                            <ol class="breadcrumb">         
                                <li><a href="{{url('/Devices')}}">Device</a></li>
                                <li class="active">Edit</a>
                            </ol>
                        </div>
                    </div>
                </div>
        </div>
        <div class="panelp-body">
            <header class="section-header">
                
            </header>

            {{ Html::ul($errors->all()) }}
            {!! Form::model($device, array('url' => array('/Devices/update', $device->id),'id'=>'add_content','name'=>'add_content','class'=>'form-horizontal', 'method' => 'PUT')) !!}
                <div class="form-group">
                    <label class="col-lg-2 control-label" style="font-weight: bold;padding-top: 1%;">Device ID</label>
                    <div class="col-lg-10">
                        {!! Form::text('device_id', Input::old('device_id'), array('class' => 'form-control input-sm','placeholder'=>'Device ID')) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label" style="font-weight: bold;padding-top: 1%;">Name</label>
                    <div class="col-lg-10">
                        {!! Form::text('name', Input::old('name'), array('class' => 'form-control input-sm','placeholder'=>'Name')) !!}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-lg-2 control-label" style="font-weight: bold;padding-top: 1%;">Channel</label>
                    <div class="col-lg-10">
                        {!! Form::select('channel_id', $channels, Input::old('channel_id') , array('class' => 'form-control input-sm')) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-lg-2 control-label" style="font-weight: bold;padding-top: 1%;">Location</label>
                    <div class="col-lg-10">
                        {!! Form::text('location', Input::old('location'), array('class' => 'form-control input-sm','placeholder'=>'Location')) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-lg-2 control-label" style="font-weight: bold;padding-top: 1%;">Secret</label>
                    <div class="col-lg-10">
                        {!! Form::text('secret', Input::old('secret'), array('class' => 'form-control input-sm','placeholder'=>'Secret')) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-lg-2 control-label" style="font-weight: bold;padding-top: 1%;">Notes</label>
                    <div class="col-lg-10">
                        {!! Form::textarea('notes', Input::old('notes'), array('class' => 'form-control input-sm','id'=>'editor','style'=>'display:none')) !!}
                        <textarea id="text_content" class="form-control input-sm btn-toolbar"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group" style="margin-top:10px;">                
                    <div class="col-lg-offset-1 col-lg-2" >
                        <a class="pull-right btn btn-danger" href="{{url('/Devices')}}">
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
@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" media="screen" href="{{asset('css/editor.css?v=1')}}" />
@endsection
@section('scripts')
    <script type="text/javascript" src="{{asset('js/jquery.form.js?v=1')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.validate.min.js?v=1')}}"></script>
    <script type="text/javascript" src="{{asset('js/editor.js')}}"></script>
    <script type="text/javascript">
    function submitMe(){
        $('#editor').text($('#text_content').Editor("getText"));  
        $('#add_content').submit();
    }
    $(document).ready(function(){
        $('#text_content').Editor();
        $('#text_content').Editor('setText',[$('#editor').text()]);
        
        
        options = {
                rules: {
                    "deveice_id": "required",
                    "name": "required",
                    "group_id": "required"
                },
                messages: {
                    "deveice_id": "Please enter Device ID ",
                    "name": "Please enter Device Name",
                    "channel_id": "Please Select channel"
                }
            };
            
            $('#add_content').validate( options );
    });
    </script>
@endsection