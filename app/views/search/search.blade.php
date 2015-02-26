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
					<ul class="tabs">
						<li><a class="tab-link {{$tab['all_class']}}" id="{{$tab['all_link']}}">All Cars {{$tab['all_count']}}</a></li>
						<li><a class="tab-link {{$tab['used_class']}}" id="{{$tab['used_link']}}">Used Cars {{$tab['used_count']}}</a></li>
						<li><a class="tab-link {{$tab['new_class']}}" id="{{$tab['new_link']}}">New Cars {{$tab['new_count']}}</a></li>
					</ul>
					@if(sizeof($results) > 0)
						@foreach($results as $key=>$result)
							@if($featured == $key)
								<div class="row">
									<div class="small-12 columns">
										<p class="secondary-text subhead"><strong>FEATURED VEHICLES</strong></p>
									</div>
								</div>
							@endif
							@if($standard == $key)
								<div class="row">
									<div class="small-12 columns">
										<p class="secondary-text subhead"><strong>STANDARD VEHICLES</strong></p>
									</div>
								</div>
							@endif
							@include('search/search-vehicle')
						@endforeach
						@include('search/search-pager')
					@else
						<p>No Results Found</p>
						<p>Try expanding your search radius.</p>
						{{ Form::select('distance_no_results', [
							'10' => '10 Miles',
							'25' => '25 Miles',
							'50' => '50 Miles',
							'75' => '75 Miles',
							'100' => '100 Miles',
							'150' => '150 Miles',
							'200' => '200 Miles',
							'250' => '250 Miles',
							'500' => '500 Miles',
							'0' => 'Unlimited'], $distance, array('class' => 'distance_no_results'))
						}}
					@endif
				</div>
			</div>
		</section>
		<a class="exit-off-canvas"></a>
	</div>
</div>
@stop