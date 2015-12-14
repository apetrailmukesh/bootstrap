@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	<div class="small-12 medium-7 large-7 columns small-centered">
		<div class="panel callout radius">
			<div class="row">
				<p class="alert">{{ $message }}</p>
			</div>	
		</div>
	</div>		
</section>
@stop