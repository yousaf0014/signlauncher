@extends('layouts.admin.layout')
<!-- if there are creation errors, they will show here -->
@section('content')
    <div class="panelp panelp-default">
        <div class="panelp-heading">
            <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <div class="pull-left">
                                <h3>Edit Channel</h3>
                            </div>
                            <div class"pull-right">
                                <a class="pull-right btn btn-default btn-sm m-r-1" href="{{url('/Channels')}}">
                                    <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
                                </a>        
                                <a href="javascript:;" onclick="submitMe()" class="btn btn-default pull-right btn-sm m-r-1">Save</a>
                            </div>
                            <div class="clearfix"></div>
                            <ol class="breadcrumb">         
                                <li><a href="{{url('/Channels')}}">Channels</a></li>
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
            {!! Form::model($channel, array('url' => array('/Channels/update', $channel->id),'id'=>'add_content','name'=>'add_content','class'=>'form-horizontal', 'method' => 'PUT')) !!}
                <div class="row">
                <div class="form-group">
                    <label class="col-lg-2 control-label" style="padding-top: 1%;font-weight: bold;">Name</label>
                    <div class="col-lg-10">
                        {!! Form::text('name', Input::old('name'), array('class' => 'form-control input-sm','placeholder'=>'Name')) !!}
                    </div>
                </div>
                </div>
                <div class="row">
                <div class="form-group">
                    <label class="col-lg-2 control-label" style="padding-top: 1%;font-weight: bold;">Base Play List</label>
                    <div class="col-lg-10">
                        {!! Form::select('playlist_id', $playListes, Input::old('playlist_id') , array('class' => 'form-control input-sm')) !!}
                    </div>
                </div>
                </div>

                <div class="clearfix"></div>
                <div class="form-group" style="margin-top:10px;">                
                    <div class="col-lg-offset-1 col-lg-2" >
                        <a class="pull-right btn btn-danger" href="{{url('/Channels')}}">
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
    function submitMe(){        
        $('#add_content').submit();
    }
    $(document).ready(function(){
        options = {
                rules: {
                    "name": "required",
                    "playlist_id": "required"
                },
                messages: {
                    "name": "Please enter Channel Name",
                    "playlist_id": "Please Select Base PlayList"
                }
            };
            
            $('#add_content').validate( options );
    });
    </script>
@endsection
