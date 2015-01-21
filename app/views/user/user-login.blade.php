@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	{{ Form::open(array('route' => 'post.user.login')) }}
		<div class="row">
			<div class="small-12 medium-7 large-7 columns small-centered">
				<div class="row collapse">
					<div class="small-10 medium-11 large-11 columns">
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
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}
</section>
@stop