@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	{{ Form::open(array('route' => 'post.admin.specifications.add')) }}
		<div class="row">
			<div class="small-12 medium-7 large-7 columns small-centered">
				<div class="row collapse">
					<div class="small-10 medium-11 large-11 columns">
						<ul>
					        @foreach($errors->all() as $error)
					            <li>{{ $error }}</li>
					        @endforeach
					    </ul>
						{{ Form::text('name', Input::old('name'),  array('placeholder'=>'Specification type name')) }}
						{{ Form::text('display', Input::old('display'),  array('placeholder'=>'Specification type display name')) }}
						{{ Form::select('type', [
							'' => 'Select data type',
							'Integer' => 'Integer',
							'Boolean' => 'Boolean',
							'String' => 'String',
							'Double' => 'Double'], '')
						}}
						{{ Form::checkbox('enabled', 'true', 1) }} Enabled
						<button type="submit" class="button postfix">SAVE</button>
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}
</section>
@stop