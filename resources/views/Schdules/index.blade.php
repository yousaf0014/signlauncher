@extends('layouts.admin.layout')

@section('content')
<div class="panelp panelp-default">
    <div class="panelp-heading">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <div class="pull-left">
                        <h1>Schdule({{$channel->name}}) Management</h1>
                    </div>
                    <div class"pull-right">
                            <a class="pull-right btn btn-default btn-sm m-r-1 radius-none" href="{{url('/Channels')}}">
                                <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;Go Back
                            </a>                                    
                        <a href="{{url('/Schdules/create',$channel->id)}}" style="margin-right:10px;" class="pull-right btn btn-success btn-sm radius-none">Add New Schdule</a>
                    </div>
                    <div class="clearfix"></div>
                    <ol class="breadcrumb">         
                        <li><a href="{{url('/Channels')}}">Channels</a></li>
                        <li><a href="{{url('/Schdules')}}">Schdules</a></li>
                    </ol>
                </div>
            </div>
        </div>

    </div>
    <div class="panelp-body">
        <header class="section-header">
            
        </header>                        
            
        <table style="width:100%" class="table table-bordered table-striped table-hover" cellspacing="0" cellpadding="5">
            <tr>        
                <th class="text-center" width="5%">#</th>
                <th class="text-center">Channel Name</th>
                <th class="text-center">Play List</th>
                <th class="text-center">Start Time</th>
                <th class="text-center">End Time</th>
                <th class="text-center">Duration</th>
                <th class="text-center" width="15%">Actions</th>
            </tr>
            
            <?php 
            $page = $schdules->lastPage();
            $counter = ($schdules->currentPage()-1) * $schdules->perPage();
            $total = count($schdules);
            ?>
            @foreach ($schdules as $cnt)
                <?php $counter++; ?>
                <tr >
                    <td class="text-center">{{$counter}}</td>
                    <td class="text-center">
                        {{$channel->name}}
                    </td>
                    <td class="text-center">{{!empty($playListes[$cnt->playlist_id]) ? $playListes[$cnt->playlist_id]:''}}</td>
                    <td class="text-center">{{$cnt->start_time}}</td>
                    <td class="text-center">{{$cnt->end_time}}</td>
                    <td class="text-center">{{$cnt->duration}}</td>
                    <td class="text-center">
                        <a href="{{url('/Schdules/edit/'.$cnt->id,$channel->id)}}" title="Edit Content" class="edit_info">
                            <span class="glyphicon glyphicon-pencil"></span></a> &nbsp;

                        {!! Form::open(array('url' => '/Schdules/' . $cnt->id ,'id'=>'delete_'.$cnt->id,'class' => 'pull-right')) !!}
                            {!! Form::hidden('_method', 'DELETE') !!}
                        {!! Form::close() !!}


                        <a onclick="show_alert('{{$cnt->id}}')" href="javascript:;" title="Delete">
                            <span class="glyphicon glyphicon-trash mr5"></span>
                        </a> &nbsp;                        
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $schdules->links() !!}
    
    
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
