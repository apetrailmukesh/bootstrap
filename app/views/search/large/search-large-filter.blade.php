<div class="large-3 medium-4 columns">
	<div class="hide-for-small"> <!-- filters for medium and up screensizes -->
		<div class="sidebar">
			<div class="filters-selected">
				<h3>Your Search</h3>
				<nav>
					<ul class="side-nav">
						@foreach($filters as $filter)
							<li>{{ $filter['name'] }}</li>
							@foreach($filter['values'] as $value)
								<li>
									<a class="fa-icon close" id="{{ $value['index'] }}">{{ $value['title'] }}</a>
								</li>	
							@endforeach	
						@endforeach
					</ul>
				</nav>
				<a class="button radius">Save Search</a>
				<!-- <p>
					<a class="fa-icon email-alerts">Get Email Alerts</a>
					<span class="secondary-text">when we find new vehicles that match this search</span>
				</p> -->
			</div>
			<div class="filters">
				<h3>Refine Results</h3>
				<nav>
					<ul class="side-nav">
						<li><a class="fa-icon plus" data-reveal-id="priceModal">Price</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mileageModal">Mileage</a></li>
						<li><a class="fa-icon plus" data-reveal-id="yearModal">Year</a></li>
						<li><a class="fa-icon plus" data-reveal-id="transmissionModal">Transmission</a></li>
						<li><a class="fa-icon plus" data-reveal-id="photoModal">Has Photos</a></li>
					</ul>
				</nav>
				@include('search/large/search-large-filter-price')
				@include('search/large/search-large-filter-mileage')
				@include('search/large/search-large-filter-year')
				@include('search/large/search-large-filter-transmission')
				@include('search/large/search-large-filter-photo')
			</div>
		</div>
	</div>
</div>