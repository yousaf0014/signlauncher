@extends('layouts.admin.layout')
<!-- if there are creation errors, they will show here -->
@section('content')
    <div class="panelp panelp-default">
        <div class="panelp-heading">
            <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <div class="pull-left">
                                <h3>Play Lists</h3>
                            </div>
                            <div class"pull-right">
                                <a class="pull-right btn btn-default btn-sm m-r-1 radius-none" href="{{url('/PlayLists')}}">
                                    <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
                                </a>        
                                <a href="javascript:;" onclick="submitMe()" class="btn btn-default pull-right btn-sm m-r-1 radius-none">Save</a>
                            </div>
                            <div class="clearfix"></div>
                            <ol class="breadcrumb">         
                                <li><a href="{{url('/playLists')}}">Play Lists</a></li>
                                <li class="active">Design</a>
                            </ol>
                        </div>
                    </div>
                </div>
        </div>
        <div class="panelp-body">
            <header class="section-header">
            </header>
            {{ Html::ul($errors->all()) }}
            {!! Form::open(array('url' => 'designPage/'.$playList->id,'id'=>'add_design','name'=>'add_design','class'=>'form-horizontal','enctype'=>'multipart/form-data')) !!}
                
                <div class="form-group">
                    <label for="inputName" class="col-lg-2 control-label" style="padding-top: 1%;font-weight: bold;">Notes</label>
                    <div class="col-lg-10">
                        {!! Form::textarea('pagedesign', !empty($project->design) ? $project->design:'', array('class' => 'form-control input-sm','id'=>'editor','style'=>'display:none')) !!}
                        <textarea id="text_content" class="form-control input-sm btn-toolbar"></textarea>
                    </div>
                </div>
                
                <div class="clearfix"></div>
                <div class="form-group" style="margin-top:10px;">                
                    <div class="col-lg-offset-1 col-lg-2" >
                        <a class="pull-right btn btn-danger radius-none" href="{{url('/PlayLists')}}">
                        <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back</a>
                    </div>
                    <div class="col-lg-offset-1">
                        <button type="button" onclick="submitMe()" class="btn btn-primary btn-sm save-btn radius-none">Save</button>                    
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
        $('#add_design').submit();
    }
    $(document).ready(function(){
        $('#text_content').Editor();
        $('#text_content').Editor('setText',[$('#editor').text()]);
    });
    </script>
@endsection