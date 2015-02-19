@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	<div class="row">
		<div class="small-12 medium-7 large-7 columns small-centered">
			<div class="panel callout radius">
				<p class="tagline secondary-text">User Login</p>
				<div class="row collapse">
					<div class="small-12 medium-12 large-12 columns">
						{{ Form::open(array('route' => 'post.user.login')) }}
							@if(Session::has('message'))
	            				<p class="alert">{{ Session::get('message') }}</p>
	       					@endif
							<ul>
						        @foreach($errors->all() as $error)
						            <li>{{ $error }}</li>
						        @endforeach
						    </ul>
							{{ Form::text('email', Input::old('email'),  array('placeholder'=>'Email address')) }}
							{{ Form::password('password', array('placeholder'=>'Password')) }}
							<button type="submit" class="button postfix">SIGN IN</button>
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop