@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	<div class="row">
		<div class="small-12 medium-7 large-7 columns small-centered">
			<div class="panel callout radius">
				<p class="tagline secondary-text">Upload File</p>
				{{ Form::open(array('route' => 'post.admin.upload', 'files'=>true)) }}
					<div class="row">
						<div class="small-12 medium-12 large-12 columns">
							@if(Session::has('message'))
								<p class="alert">{{ Session::get('message') }}</p>
							@endif
							{{ Form::file('file', '', array('id'=>'','placeholder'=>'Select file')) }}
							<button type="submit" class="button postfix">UPLOAD</button>
						</div>
					</div>
				{{ Form::close() }}
			</div>
			<div class="panel">
				<p class="tagline secondary-text">Uploaded Files</p>
				<table width="100%">
					<thead>
						<tr>
							<th width="70%">Name</th>
							<th width="30%" class="number-column">Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($files->all() as $file)
							<tr>
								<td>{{ $file->name }}</td>
								<td class="number-column">{{ $file->status }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
@stop