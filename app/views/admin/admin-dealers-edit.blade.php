@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	{{ Form::open(array('route' => 'post.admin.dealers.edit')) }}
		<div class="row">
			<div class="small-12 medium-7 large-7 columns small-centered">
				<div class="row collapse">
					<div class="small-10 medium-11 large-11 columns">
					    {{ Form::hidden('id', $id) }}
						{{ Form::text('name', $name,  array('disabled')) }}
						{{ Form::checkbox('paid', 'paid', $paid) }} Paid
						{{ Form::text('clicks', $clicks,  array('placeholder'=>'Clicks per Month')) }}
						<button type="submit" class="button postfix">UPDATE</button>
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}
</section>
@stop