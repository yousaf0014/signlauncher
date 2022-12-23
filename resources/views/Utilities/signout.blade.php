@extends('layouts.admin.layout')
@section('content')
<form id="logout-form" 
    action="{{ url('/logout') }}" 
    method="POST" 
    style="display: none;">
            {{ csrf_field() }}
</form>
@endsection
@section('scripts')

<script>
    $(document).ready(function(){
        $('#logout-form').submit();
    });
</script>

@endsection
