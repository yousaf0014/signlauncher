<h1 class="pull-left text-info">	
	<a href="{{ url('/dashboard') }}">{{ config('app.name', 'FayazSons') }}</a>
</h1>
<div class="pull-right" style="margin: 20px 10px;">
    @if (Route::has('login'))
    	<a href="{{ url('/logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();"class="btn btn-danger mt20"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout
        </a>
    @endif

    <form id="logout-form" 
            action="{{ url('/logout') }}" 
        method="POST" 
        style="display: none;">
                    {{ csrf_field() }}
      </form>
</div>
<div class="clearfix"></div>