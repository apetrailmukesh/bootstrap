@section('contents')
<div class="marketing off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">
		<header>
			@include('header')
			@include('search/search-header')
		</header>
		<section role="main">
			<header>
				@include('search/mobile/search-mobile-filter')
				@include('search/search-title')
			</header>
			<div class="row">
				@include('search/large/search-large-filter')
				<div class="large-9 medium-8 columns">
					@foreach($results as $result)
						@include('search/search-vehicle')
					@endforeach
					@include('search/search-pager')
				</div>
			</div>
		</section>
		<a class="exit-off-canvas"></a>
	</div>
</div>
@stop