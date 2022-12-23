@extends('layouts.admin.layout')

@section('content')
<div class="panelp panelp-default">
    <div class="panelp-heading">
        <h1>PlayList Management</h1>
    </div>
    <div class="panelp-body">
        <header class="section-header">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <div class="pull-left">
                        </div>
                        <div class"pull-right">
                            <form id="searchCompanies" name="searchSs" class="pull-right" action="{{url('/PlayLists')}}">
                                <input type="text" value="{{isset($keyword) ? $keyword : ''}}" name="keyword" class="form-control input-sm pull-left" style="width:150px; margin-right:5px;height: 28px;" />
                                <a href="javascript:{}" class="btn btn-primary btn-sm" onclick="$('#searchCompanies').submit();">Search</a>
                                <a href="{{url('/PlayLists/create/')}}" class="btn btn-success btn-sm">Add New Play List</a>
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
                <th class="text-center">Name</th>
                <th class="text-center">View Design</th>
                <th class="text-center">Duration</th>
                <th class="text-center" width="15%">Actions</th>
            </tr>
            
            <?php 
            $page = $playLists->lastPage();
            $counter = ($playLists->currentPage()-1) * $playLists->perPage();
            $total = count($playLists);
            ?>
            @foreach ($playLists as $cnt)
                <?php $counter++; ?>
                <tr >
                    <td class="text-center">{{$counter}}</td>
                    <td class="text-center">
                      <?php  $url = url('/');
                      	$url1 = str_replace('/backend','',$url);
                      ?>
                      <a href="{{url('designPage/'.$cnt->id)}}">{{$cnt->name}}</a>
                    </td>
                    <td>
                        <?php if(!empty($cnt->project->id)){ ?>
                            <a href="{{url('viewdesignPage/'.$cnt->id)}}" target="_blank">View Design</a>   
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        {{$cnt->duration}}
                    </td>

                    <td class="text-center">
                        <a href="{{url('/PlayLists/'.$cnt->id.'/edit')}}" title="Edit Content" class="edit_info">
                            <span class="glyphicon glyphicon-pencil"></span></a> &nbsp;

                        {!! Form::open(array('url' => '/PlayLists/' . $cnt->id ,'id'=>'delete_'.$cnt->id,'class' => 'pull-right')) !!}
                            {!! Form::hidden('_method', 'DELETE') !!}
                        {!! Form::close() !!}


                        <a onclick="show_alert('{{$cnt->id}}')" href="javascript:;" title="Delete">
                            <span class="glyphicon glyphicon-trash mr5"></span>
                        </a> &nbsp;
                        
                        <a title="Preview" href="{{url('/PlayLists',$cnt->id)}}"><span class="glyphicon glyphicon-eye-open"></span></a>
                        &nbsp;

                        
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $playLists->links() !!}
    
    
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
