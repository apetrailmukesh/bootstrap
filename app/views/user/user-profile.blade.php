@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	{{ Form::open(array('route' => 'post.user.profile')) }}
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
						{{ Form::text('first_name', $first_name,  array('placeholder'=>'First name')) }}
						{{ Form::text('last_name', $last_name,  array('placeholder'=>'Last name')) }}
						<button type="submit" class="button postfix">UPDATE</button>
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}
</section>
@stop