@extends('layouts.admin.layout')

@section('content')
<div class="panelp panelp-default">
  <div class="panelp-heading">
    <div class="panelp-body">

        <header class="section-header">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <div class="pull-left">
                            <h3>Users</h3>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </header>

        <div class="box-typical box-typical-padding">
                        
            <div class="form-group row">
                <label class="col-sm-2 form-control-label" style="color: #000000;font-weight: bold;">Name:</label>
                <div class="col-sm-10" style="color: #000000;">
                    {{$user->name}}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label" style="color: #000000;font-weight: bold;">Email:</label>
                <div class="col-sm-10" style="color: #000000;">
                    {{$user->email}}
                </div>
            </div>    
        </div>
    </div>
</div>            
@endsection
