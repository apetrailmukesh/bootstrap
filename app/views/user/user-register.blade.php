@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	{{ Form::open(array('route' => 'post.user.register')) }}
		<div class="row">
			<div class="small-12 medium-7 large-7 columns small-centered">
				<div class="row collapse">
					<div class="small-10 medium-11 large-11 columns">
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
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}
</section>
@stop