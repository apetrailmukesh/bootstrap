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
			</div>
			<div class="filters">
				<h3>Refine Results</h3>
				<nav>
					<ul class="side-nav">
						<li><a class="fa-icon plus" data-reveal-id="makeModal">Make</a></li>
						<li><a class="fa-icon plus" data-reveal-id="modelModal">Model</a></li>
						<li><a class="fa-icon plus" data-reveal-id="priceModal">Price</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mileageModal">Mileage</a></li>
						<li><a class="fa-icon plus" data-reveal-id="yearModal">Year</a></li>
						<li><a class="fa-icon plus" data-reveal-id="bodyModal">Style</a></li>
						<li><a class="fa-icon plus" data-reveal-id="certifiedModal">Certification</a></li>
						<li><a class="fa-icon plus" data-reveal-id="exteriorModal">Exterior Color</a></li>
						<li><a class="fa-icon plus" data-reveal-id="interiorModal">Interior Color</a></li>
						<li><a class="fa-icon plus" data-reveal-id="cylindersModal">Cylinders</a></li>
						<li><a class="fa-icon plus" data-reveal-id="transmissionModal">Transmission</a></li>
						<li><a class="fa-icon plus" data-reveal-id="driveModal">Drivetrain</a></li>
						<li><a class="fa-icon plus" data-reveal-id="fuelModal">Fuel</a></li>
						<li><a class="fa-icon plus" data-reveal-id="doorsModal">Door Count</a></li>
						<li><a class="fa-icon plus" data-reveal-id="statusModal">Condition</a></li>
						<li><a class="fa-icon plus" data-reveal-id="photoModal">Photos</a></li>
					</ul>
				</nav>
				@include('search/large/search-large-filter-make')
				@include('search/large/search-large-filter-model')
				@include('search/large/search-large-filter-price')
				@include('search/large/search-large-filter-mileage')
				@include('search/large/search-large-filter-year')
				@include('search/large/search-large-filter-body')
				@include('search/large/search-large-filter-certified')
				@include('search/large/search-large-filter-exterior')
				@include('search/large/search-large-filter-interior')
				@include('search/large/search-large-filter-cylinders')
				@include('search/large/search-large-filter-transmission')
				@include('search/large/search-large-filter-drive')
				@include('search/large/search-large-filter-fuel')
				@include('search/large/search-large-filter-doors')
				@include('search/large/search-large-filter-status')
				@include('search/large/search-large-filter-photo')
				
			</div>
		</div>
	</div>
</div>