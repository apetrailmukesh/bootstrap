@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	<div class="small-12 medium-7 large-7 columns small-centered">
		<div class="panel callout radius">
			<p class="tagline secondary-text">{{ $key }}</p>
			{{ Form::open(array('route' => 'post.admin.settings.edit')) }}
				<div class="row">
				    {{ Form::hidden('id', $id) }}
					{{ Form::text('value', $value,  array('placeholder'=>'Value')) }}
					<button type="submit" class="button postfix">UPDATE</button>
				</div>
			{{ Form::close() }}
		</div>
	</div>
</section>
@stop