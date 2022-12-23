@extends('layouts.admin.layout')
<!-- if there are creation errors, they will show here -->
@section('content')
    <div class="panelp panelp-default">
        <div class="panelp-heading">
            <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <div class="pull-left">
                                <h3>Devices</h3>
                            </div>
                            <div class"pull-right">
                                <a class="pull-right btn btn-default btn-sm m-r-1 radius-none" href="{{url('/Invoices')}}">
                                    <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
                                </a>        
                                <a href="javascript:;" onclick="submitMe()" class="btn btn-default pull-right btn-sm m-r-1 radius-none">Save</a>
                            </div>
                            <div class="clearfix"></div>
                            <ol class="breadcrumb">         
                                <li><a href="{{url('/Invoicess')}}">Invoice</a></li>
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
            <form class="form-horizontal" method="POST" id="add_content" role="form" action="{{ route('paypal.express-checkout', ['recurring' => true]) }}">
                {{ csrf_field() }}            
                <div class="form-group">
                    <label class="col-lg-2 control-label" style="padding-top: 1%;font-weight: bold;">Cost Per Screen</label>
                    <div class="col-lg-10">
                        {{config('constants.PerScreenAmount')}} AUD
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label" style="padding-top: 1%;font-weight: bold;">Number Of Screens</label>
                    <div class="col-lg-10">
                        <input id="qty" type="text" class="form-control" name="qty" value="{{ old('qty',1) }}" autofocus>
                    </div>
                </div>
                
                <div class="clearfix"></div>
                <div class="form-group" style="margin-top:10px;">                
                    <div class="col-lg-offset-1 col-lg-2" >
                        <a class="pull-right btn btn-danger" href="{{url('/Invoices')}}">
                        <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back</a>
                    </div>
                    <div class="col-lg-offset-1">
                        <button type="button" onclick="submitMe()" class="btn btn-primary btn-sm save-btn">Paywith Paypal</button>                    
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
                    "qty": {"required":true,'digits':true}
                },
                messages: {
                    "qty": {'required':"Please enter screen count",'digits':'Must be a Digit'}
                }
            };
            
            $('#add_content').validate( options );
    });
    </script>
@endsection