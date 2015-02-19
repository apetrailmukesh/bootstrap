@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	<div class="row">
		<div class="small-12 medium-7 large-7 columns small-centered">
			<div class="panel callout radius">
				<p class="tagline secondary-text">User Profile</p>
				<div class="row collapse">
					<div class="small-12 medium-12 large-12 columns">
						{{ Form::open(array('route' => 'post.user.profile')) }}
							@if(Session::has('message'))
							<p class="alert">{{ Session::get('message') }}</p>
							@endif
							<ul>
								@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
							{{ Form::text('first_name', $first_name,  array('placeholder'=>'First name')) }}
							{{ Form::text('last_name', $last_name,  array('placeholder'=>'Last name')) }}
							<button type="submit" class="button postfix">UPDATE</button>
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop