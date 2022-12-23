@extends('layouts.admin.layout')


@section('content')

	<div class="panelp panelp-default">
    <div class="panelp-heading">
        <h1>My Libraries</h1>
    </div>
		
	</div>

	<div class="row">

		<div class="col-md-8">

			@if($galleries->count() > 0)

				<table class="table table-striped table-bordered table responsive">
					<thead>
						<tr>
							<th>Name of the library</th>
							<th></th>
						</tr>
					</thead>

					<tbody>
						@foreach($galleries as $gallery)
						<tr>
							<td>{{$gallery->name}}</td>
							<td><a href="{{url('gallery/view/' . $gallery->id)}}">View</a> / 
							    <a href="{{url('gallery/delete/' . $gallery->id)}}">Delete</a></td>
						</tr>
						@endforeach
					</tbody>
				</table>

			@endif
			
		</div>

		<div class="col-md-4">

		@if(count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

			<form class="form" method="POST" action="{{url('gallery/save')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="form-group">
						<input type="text" name="gallery_name" id="gallery_name" class="form-control" placeholder="Name of the Library" value="{{ old('gallery_name') }}">
						
					</div>

					<button class="btn btn-primary radius-none">Save</button>
				
			</form>
			
		</div>
		

	</div>



@endsection