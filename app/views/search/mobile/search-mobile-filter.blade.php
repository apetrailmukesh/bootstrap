<div class="show-for-small"> <!-- mobile filters and sort -->
	<div class="row">
		<div class="small-12 columns">
			<div class="row">
				<div class="small-7 columns">
					<a href="#" class="button radius small left-off-canvas-toggle">Refine Search</a>
				</div>
				<div class="small-5 text-right columns">
					<a href="#" data-reveal-id="mobileSort" class="button radius small">Sort</a>
					@include('search/mobile/search-mobile-sort')
				</div>
			</div>
		</div>
	</div>
	<!-- mobile filters (canvas) -->
	<aside class="left-off-canvas-menu">
		<div class="sidebar">
			<div class="filters-selected">
				<h3>Your Search</h3>
				<nav>
					<ul class="side-nav">
						@foreach($filters as $filter)
							<li>{{ $filter['name'] }}</li>
							@foreach($filter['values'] as $value)
								<li>
									<a class="fa-icon close" id="mobile-{{ $value['index'] }}">{{ $value['title'] }}</a>
								</li>	
							@endforeach	
						@endforeach
					</ul>
				</nav>
				<!-- <a href="#" class="button radius">Save Search</a> -->
				<!-- <p>
					<a href="#" class="fa-icon email-alerts">Get Email Alerts</a>
					<span class="secondary-text">when we find new vehicles that match this search</span>
				</p> -->
			</div>
			<div class="filters">
				<h3>Refine Results</h3>
				<nav>
					<ul class="side-nav">
						<li><a class="fa-icon plus" data-reveal-id="mobileMakeModal">Make</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobileModelModal">Model</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobilePriceModal">Price</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobileMileageModal">Mileage</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobileYearModal">Year</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobileTransmissionModal">Transmission</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobilePhotoModal">Has Photos</a></li>
					</ul>
				</nav>
				@include('search/mobile/search-mobile-filter-make')
				@include('search/mobile/search-mobile-filter-model')
				@include('search/mobile/search-mobile-filter-price')
				@include('search/mobile/search-mobile-filter-mileage')
				@include('search/mobile/search-mobile-filter-year')
				@include('search/mobile/search-mobile-filter-transmission')
				@include('search/mobile/search-mobile-filter-photo')
			</div>
		</div>
	</aside>
</div>