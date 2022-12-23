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
                            <a class="pull-right btn btn-default btn-sm m-r-1" href="{{url('/PlayLists')}}">
                                <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
                            </a>                            
                        </div>
                        <div class="clearfix"></div>
                        <ol class="breadcrumb">         
                            <li><a href="{{url('/PlayLists')}}">Play Lists</a></li>
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
                    <td class="text-center"><strong>Name</strong></td>
                    <td class="text-left">{{$playList->name}}</td>
                </tr>
                <tr>
                    <td class="text-center"><strong>Duration</strong></td>
                    <td class="text-left">{{$playList->duration}}</td>
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