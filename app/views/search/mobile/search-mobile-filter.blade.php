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
						<li><a class="fa-icon plus" data-reveal-id="mobileBodyModal">Style</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobileCertifiedModal">Certification</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobileExteriorModal">Exterior Color</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobileInteriorModal">Interior Color</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobileCylindersModal">Cylinders</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobileTransmissionModal">Transmission</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobileDriveModal">Drivetrain</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobileFuelModal">Fuel</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobileDoorsModal">Door Count</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobileStatusModal">Condition</a></li>
						<li><a class="fa-icon plus" data-reveal-id="mobilePhotoModal">Photos</a></li>
					</ul>
				</nav>
				@include('search/mobile/search-mobile-filter-make')
				@include('search/mobile/search-mobile-filter-model')
				@include('search/mobile/search-mobile-filter-price')
				@include('search/mobile/search-mobile-filter-mileage')
				@include('search/mobile/search-mobile-filter-year')
				@include('search/mobile/search-mobile-filter-body')
				@include('search/mobile/search-mobile-filter-certified')
				@include('search/mobile/search-mobile-filter-exterior')
				@include('search/mobile/search-mobile-filter-interior')
				@include('search/mobile/search-mobile-filter-cylinders')
				@include('search/mobile/search-mobile-filter-transmission')
				@include('search/mobile/search-mobile-filter-drive')
				@include('search/mobile/search-mobile-filter-fuel')
				@include('search/mobile/search-mobile-filter-doors')
				@include('search/mobile/search-mobile-filter-status')
				@include('search/mobile/search-mobile-filter-photo')
			</div>
		</div>
	</aside>
</div>