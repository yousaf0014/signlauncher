@extends('layouts.admin.layout')

@section('content')
    <div class="panelp panelp-default">
        <div class="panelp-heading">
            <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <div class="pull-left">
                                <h3>Paywith Paypal</h3>
                            </div>
                            <div class"pull-right">
                                <a class="pull-right btn btn-default btn-sm m-r-1 radius-none" href="{{url('/Devices')}}">
                                    <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
                                </a>        
                                <a href="javascript:;" onclick="submitMe()" class="btn btn-default pull-right btn-sm m-r-1 radius-none">Save</a>
                            </div>
                            <div class="clearfix"></div>
                            <ol class="breadcrumb">         
                                <li><a href="{{url('/Devices')}}">Devices</a></li>
                                <li class="active">Pay</a>
                            </ol>
                        </div>
                    </div>
                </div>
        </div>
        <div class="panelp-body">
            <header class="section-header">                
            </header>
            @if ($message = Session::get('success'))
            <div class="custom-alerts alert alert-success fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                {!! $message !!}
            </div>
            <?php Session::forget('success');?>
            @endif

            @if ($message = Session::get('error'))
            <div class="custom-alerts alert alert-danger fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                {!! $message !!}
            </div>
            <?php Session::forget('error');?>
            @endif

            <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{ route('paypal.express-checkout', ['recurring' => true]) }}">
                <div class="row">
                    {{ csrf_field() }}            
                    <div class="form-group">
                        <label class="col-lg-3 control-label" style="padding-top: 1%;font-weight: bold;">Cost Per Screen</label>
                        <div class="col-lg-9">
                            {{config('constants.PerScreenAmount')}} AUD
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" style="padding-top: 1%;font-weight: bold;">Number Of Screens</label>
                        <div class="col-lg-9">
                            <input id="qty" type="text" class="form-control" name="qty" value="{{ old('qty',1) }}" autofocus>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group" style="margin-top:10px;">                
                    <div class="offset-md-3 col-lg-2" >
                        <a class="pull-right btn btn-danger" href="{{url('/Channels')}}">
                        <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back</a>
                    </div>
                    <div class="offset-md-1">
                        <button type="submit" class="btn btn-primary">
                            Paywith Paypal
                        </button>                    
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection