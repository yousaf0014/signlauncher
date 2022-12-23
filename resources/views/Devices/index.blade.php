@extends('layouts.admin.layout')

@section('content')
<div class="panelp panelp-default">
    <div class="panelp-heading">
        <h1>Device Management</h1>
    </div>
    <div class="panelp-body">
        <header class="section-header">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <div class="pull-left">
                        </div>
                        <div class"pull-right">
                            <form id="searchCompanies" name="searchSs" class="pull-right" action="{{url('/Devices')}}">
                                <input type="text" value="{{isset($keyword) ? $keyword : ''}}" name="keyword" class="form-control input-sm pull-left" style="width:150px; margin-right:5px;height: 28px;" />
                                <a href="javascript:{}" class="btn btn-primary btn-sm" onclick="$('#searchCompanies').submit();">Search</a>
                                <?php 
                                if(canAddDevice()){ ?>
                                    <a href="{{url('/Devices/create/')}}" class="btn btn-success btn-sm">Add Device</a>
                                <?php }else{?> 
                                    <a href="{{url('/Invoices/create')}}" class="btn btn-success btn-sm">Add Device & Payment</a>
                                <?php } ?>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </header>       
            
        <table style="width:100%" class="table table-bordered table-striped table-hover" cellspacing="0" cellpadding="5">
            <tr>        
                <th class="text-center" width="5%">#</th>
                <th class="text-center">Device ID</th>
                <th class="text-center">Name</th>
                <th class="text-center">Channel</th>
                <th class="text-center">Location</th>                
                <th class="text-center">Secret</th>
              <th class="text-center" width="15%">Actions</th>
            </tr>
            
            <?php 
            $page = $devices->lastPage();
            $counter = ($devices->currentPage()-1) * $devices->perPage();
            $total = count($devices);
            ?>
            @foreach ($devices as $cnt)
                <?php $counter++; ?>
                <tr >
                    <td class="text-center">{{$counter}}</td>
                    <td class="text-center">
                        {{$cnt->device_id}}
                    </td>
                    <td class="text-center">
                        {{$cnt->name}}
                    </td>

                    <td class="text-center">{{!empty($channels[$cnt->channel_id]) ? $channels[$cnt->channel_id]:''}}</td>
                    <td class="text-center">
                        {{$cnt->location}}
                    </td>
                    <td class="text-center">
                        {{$cnt->secret}}
                    </td>
                    <td class="text-center">

                        <a href="{{url('/Devices/'.$cnt->id.'/edit')}}" title="Edit Content" class="edit_info">
                            <span class="glyphicon glyphicon-pencil"></span></a> &nbsp;

                        {!! Form::open(array('url' => '/Devices/' . $cnt->id ,'id'=>'delete_'.$cnt->id,'class' => 'pull-right')) !!}
                            {!! Form::hidden('_method', 'DELETE') !!}
                        {!! Form::close() !!}


                        <a onclick="show_alert('{{$cnt->id}}')" href="javascript:;" title="Delete">
                            <span class="glyphicon glyphicon-trash mr5"></span>
                        </a> &nbsp;
                        
                        <a title="Preview" href="{{url('/Devices',$cnt->id)}}"><span class="glyphicon glyphicon-eye-open"></span></a>
                        &nbsp;

                        
                    </td>
                    
                </tr>
            @endforeach
        </table>
        {!! $devices->links() !!}
    
    
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                jhihih
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script>
function hideModal(){
    jQuery('#myModal').modal('hide');
}
    $(document).ready(function(){
        $.ajaxSetup({
           headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        $("#myModal").on("show.bs.modal", function(e) {
            url =  $(e.relatedTarget).data('target-url');
            $.get( url , function( data ) {
                $(".modal-body").html(data);
            });

        });
    });


    function show_alert(id) {
        if(confirm('Are you sure? you want to delete.')){
            $('#delete_'+id).submit();
        }else{
            return false;
        }
    }


    $(document).ready(function() {
        //$('a.main_image').nyroModal({width:350, height:150});
        //$('a.edit_info').nyroModal({width:600, height:400});
    });
</script>

@endsection
