@extends('layouts.admin.layout')

@section('content')
<div class="panelp panelp-default">
    <div class="panelp-heading">
        <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <div class="pull-left">
                        </div>
                        <div class"pull-right">
                            <a class="pull-right btn btn-default btn-sm m-r-1" href="{{url('/Devices')}}">
                                <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
                            </a>                            
                        </div>
                        <div class="clearfix"></div>
                        <ol class="breadcrumb" style="margin-top: 2%;">         
                            <li><a href="{{url('/Devices')}}">Device</a></li>
                            <li class="active">Show</a>
                        </ol>                        
                        <div class="clearfix"></div>
                    </div>
                </div>
        </div>
    </div>
    <div class="panelp-body">
        <header class="section-header">
                
        </header>
            <table style="width:100%" class="table table-bordered table-striped table-hover" cellspacing="0" cellpadding="5">
                <tr>        
                    <th class="text-center">Field Name</th>
                    <th class="text-left">Field Value</th>
                </tr>
                <tr>
                    <td class="text-center"><strong>Device ID</strong></td>
                    <td class="text-left">{{$device->device_id}}</td>
                </tr>
                <tr>
                    <td class="text-center"><strong>Device Name</strong></td>
                    <td class="text-left">{{$device->name}}</td>
                </tr>
                <tr>
                    <td class="text-center"><strong>Device Channel</strong></td>
                    <td class="text-left">{{!empty($channels[$device->channel_id]) ? $channels[$device->channel_id]:''}}</td>
                </tr>
                <tr>
                    <td class="text-center"><strong>Location</strong></td>
                    <td class="text-left">{{$device->location}}</td>
                </tr>
                <tr>
                    <td class="text-center"><strong>Notes</strong></td>
                    <td class="text-left">{{$device->notes}}</td>
                </tr>
                <tr>
                    <td class="text-center"><strong>Secret</strong></td>
                    <td class="text-left">{{$device->secret}}</td>
                </tr>
            </table>      
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
@endsection