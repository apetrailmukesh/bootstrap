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
					<ul class="tabs status-tabs">
						<li class="tab-title {{$tab['all_class']}}" id="{{$tab['all_link']}}"><a>All<span class="hide-for-small-only"> Cars <span class="count">{{$tab['all_count']}}</span></span></a></li>
						<li class="tab-title {{$tab['used_class']}}" id="{{$tab['used_link']}}"><a>Used<span class="hide-for-small-only"> Cars <span class="count">{{$tab['used_count']}}</span></span></a></li>
						<li class="tab-title {{$tab['new_class']}}" id="{{$tab['new_link']}}"><a>New<span class="hide-for-small-only"> Cars <span class="count">{{$tab['new_count']}}</span></span></a></li>
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
					<div class="row">
						<div class="small-12 small-centered text-center column no-results">
							<h1>No Results Found</h1>
							<p>Try expanding your search radius.</p>
							<div class="row">
								<div class="small-6 medium-3 large-2 small-centered columns">
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
							</div>
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
	</section>
	<a class="exit-off-canvas"></a>
</div>
<div class="reveal-modal save-modal" id="saveVehicleModalUser" data-reveal>
	<h2>Your car has been saved.</h2>
	<a class="close-reveal-modal">&#215</a>
	<div class="row">
		<div class="small-12 columns no-left-pad">
			<p></p>
		</div>
	</div>
	<div class="row">
		<div class="small-12 medium-6 large-6 columns no-left-pad">
			<img src="images/save-cars-devices.svg">
		</div>
		<div class="small-12 medium-6 large-4 columns end">
			<p>You may view all your saved cars from below.</p>
          	<div id="interfacecontainerdiv" class="interfacecontainerdiv"></div>
			<p>
				{{ HTML::linkRoute('get.user.saved.cars', 'Saved Cars', array(), array('class' => 'small')) }}
			</p>
		</div>
	</div>
</div>
<div class="reveal-modal save-modal" id="saveSearchModalUser" data-reveal>
	<h2>Your search has been saved.</h2>
	<a class="close-reveal-modal">&#215</a>
	<div class="row">
		<div class="small-12 columns no-left-pad">
			<p></p>
		</div>
	</div>
	<div class="row">
		<div class="small-12 medium-6 large-6 columns no-left-pad">
			<img src="images/save-search-devices.svg">
		</div>
		<div class="small-12 medium-6 large-4 columns end">
			<p>You may view all your saved searches from below.</p>
          	<div id="interfacecontainerdiv" class="interfacecontainerdiv"></div>
			<p>
				{{ HTML::linkRoute('get.user.saved.searches', 'Saved Searches', array(), array('class' => 'small')) }}
			</p>
		</div>
	</div>
</div>
<div class="reveal-modal save-modal" id="saveVehicleModalGuest" data-reveal>
	<h2>Please login to save your car.</h2>
	<a class="close-reveal-modal">&#215</a>
	<div class="row">
		<div class="small-12 columns no-left-pad">
			<p></p>
		</div>
	</div>
	<div class="row">
		<div class="small-12 medium-6 large-6 columns no-left-pad">
			<img src="images/save-cars-devices.svg">
		</div>
		<div class="small-12 medium-6 large-4 columns end">
			<p>Please login or register to continue.</p>
          	<div id="interfacecontainerdiv" class="interfacecontainerdiv"></div>
			<p>
				{{ HTML::linkRoute('get.user.login', 'Login', array(), array('class' => 'small')) }} or 
				{{ HTML::linkRoute('get.user.register', 'Register', array(), array('class' => 'small')) }}
			</p>
		</div>
	</div>
</div>
<div class="reveal-modal save-modal" id="saveSearchModalGuest" data-reveal>
	<h2>Please login to save your search.</h2>
	<a class="close-reveal-modal">&#215</a>
	<div class="row">
		<div class="small-12 columns no-left-pad">
			<p></p>
		</div>
	</div>
	<div class="row">
		<div class="small-12 medium-6 large-6 columns no-left-pad">
			<img src="images/save-search-devices.svg">
		</div>
		<div class="small-12 medium-6 large-4 columns end">
			<p>Please login or register to continue.</p>
          	<div id="interfacecontainerdiv" class="interfacecontainerdiv"></div>
			<p>
				{{ HTML::linkRoute('get.user.login', 'Login', array(), array('class' => 'small')) }} or 
				{{ HTML::linkRoute('get.user.register', 'Register', array(), array('class' => 'small')) }}
			</p>
		</div>
	</div>
</div>
<input type="hidden" id="search_title" value="{{ $search_title }}">
<input type="hidden" id="search_filter" value="{{ $search_filter }}">
<input type="hidden" id="search_location" value="{{ $search_location }}">
@stop