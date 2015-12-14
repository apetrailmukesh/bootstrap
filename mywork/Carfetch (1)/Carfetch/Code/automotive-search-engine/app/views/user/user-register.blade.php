@section('contents')
<header>
	@include('header')
</header>
<section class="user-header">
	@include('logo')
	<div class="row">
		<div class="small-12 medium-7 large-7 columns small-centered">
			<div class="panel callout radius">
				<p class="tagline secondary-text">User Register</p>
				<div class="row collapse">
					<div class="small-12 medium-12 large-12 columns">
						{{ Form::open(array('route' => 'post.user.register')) }}
							<ul>
								@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
							{{ Form::text('first_name', Input::old('first_name'),  array('placeholder'=>'First name')) }}
							{{ Form::text('last_name', Input::old('last_name'),  array('placeholder'=>'Last name')) }}
							{{ Form::text('email', Input::old('email'),  array('placeholder'=>'Email address')) }}
							{{ Form::password('password', array('placeholder'=>'Password')) }}
							<button type="submit" class="button postfix">REGISTER</button>
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	</section>
	@stop