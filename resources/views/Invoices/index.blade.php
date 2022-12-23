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
                            <form id="searchCompanies" name="searchSs" class="pull-right" action="{{url('/Invoices')}}">
                                <input type="text" value="{{isset($keyword) ? $keyword : ''}}" name="keyword" class="form-control input-sm pull-left" style="width:150px; margin-right:5px;height: 28px;" />
                                <select width="200px" name="status" >
                                    <option value="">Select Status</option>
                                    <option {{ isset($status)  && $status == 'Completed'? 'selected="selected"':''}} value="Completed">Active</option>
                                    <option {{ isset($status)  && $status == 'Invalid'? 'selected="selected"':''}} value="Invalid">Non-active</option>
                                </select>
                                <a href="javascript:{}" class="btn btn-primary btn-sm" onclick="$('#searchCompanies').submit();">Search</a>
                                <a href="{{url('/Invoices/create/')}}" class="btn btn-success btn-sm">Add New Invoice</a>
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
                <th class="text-center">Invoice ID</th>
                <th class="text-center">Screen Count</th>
                <th class="text-center">Status</th>
                <th class="text-center">Used</th>
                <th class="text-center">Billing Date</th>
              <th class="text-center" width="15%">Actions</th>
            </tr>
            
            <?php 
            $page = $invoices->lastPage();
            $counter = ($invoices->currentPage()-1) * $invoices->perPage();
            $total = count($invoices);
            ?>
            @foreach ($invoices as $cnt)
                <?php $counter++; ?>
                <tr >
                    <td class="text-center">{{$counter}}</td>
                    <td class="text-center">
                        {{config('paypal.invoice_prefix') . '_' .$cnt->recurring_id}}
                    </td>
                    <td class="text-center">
                        {{$cnt->screen_count}}
                    </td>

                    <td class="text-center">{{$cnt->payment_status}}</td>
                    <td class="text-center">
                        {{$cnt->used_count}}
                    </td>
                    <td class="text-center">{{!empty($cnt->valid_till) ? YMD2MDY($cnt->valid_till):''}}</td>
                    <td class="text-center">
                        <a href="{{url('/Invoices/'.$cnt->id.'/edit')}}" title="Edit Content" class="edit_info">
                            <span class="glyphicon glyphicon-pencil"></span></a> &nbsp;
                        <a onclick="show_alert('{{$cnt->id}}')" href="javascript:;" title="Delete">
                            <span class="glyphicon glyphicon-trash mr5"></span>
                        </a> &nbsp;
                        {!! Form::open(array('url' => '/Invoices/' . $cnt->id ,'id'=>'delete_'.$cnt->id,'class' => 'pull-right')) !!}
                            {!! Form::hidden('_method', 'DELETE') !!}
                        {!! Form::close() !!}
                    </td>
                    
                </tr>
            @endforeach
        </table>
        {!! $invoices->links() !!}
    
    
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
