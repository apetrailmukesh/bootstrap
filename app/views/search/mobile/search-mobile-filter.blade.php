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
						@foreach($selected_filters as $filter)
							<li>
								<ul>
									<li>
										<span>{{ $filter['name'] }}</span>
										<a class="edit" data-reveal-id="mobile{{ ucwords($filter['modal']) }}Modal">(edit)</a>
									</li>
									@foreach($filter['values'] as $value)
										<li>
											<a class="fa-icon close" id="mobile-{{ $value['index'] }}">{{ $value['title'] }}</a>
										</li>	
									@endforeach
								</ul>
							</li>
						@endforeach
					</ul>
				</nav>
				<a class="button radius save-search" data-reveal-id="{{ $save_search_popup }}">Save Search</a>
			</div>
			<div class="filters">
				<h3>Refine Results</h3>
				<nav>
					<ul class="side-nav">
						@foreach($remaining_filters as $filter)
							<li><a class="fa-icon plus" data-reveal-id="mobile{{ ucwords($filter['modal']) }}Modal">{{ $filter['name'] }}</a></li>
						@endforeach
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
				@include('search/mobile/search-mobile-filter-dealer')
			</div>
		</div>
	</aside>
</div>