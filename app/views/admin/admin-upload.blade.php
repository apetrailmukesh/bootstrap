@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	{{ Form::open(array('route' => 'post.admin.upload', 'files'=>true)) }}
	<div class="row">
		<div class="small-12 medium-7 large-7 columns small-centered">
			<div class="row collapse">
				<div class="small-10 medium-11 large-11 columns">
					@if(Session::has('message'))
					<p class="alert">{{ Session::get('message') }}</p>
					@endif
					{{ Form::select('action', [
							'Insert' => 'Insert',
							'Delete' => 'Delete'], $action)
					}}
					{{ Form::file('file', '', array('id'=>'','placeholder'=>'Select file')) }}
					<button type="submit" class="button postfix">UPLOAD</button>
				</div>
			</div>
		</div>
	</div>
	{{ Form::close() }}
	<div class="row">
		<div class="small-12 medium-7 large-7 columns small-centered">
			<div class="row collapse">
				<div class="small-10 medium-11 large-11 columns">
					<table width="100%">
						<thead>
							<tr>
								<th>Name</th>
								<th>Action</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							@foreach($files->all() as $file)
								<tr>
									<td>{{ $file->name }}</td>
									<td>{{ $file->action }}</td>
									<td>{{ $file->status }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@stop