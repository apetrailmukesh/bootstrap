<div class="large-3 medium-4 columns">
	<div class="hide-for-small"> <!-- filters for medium and up screensizes -->
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
                            			<a class="edit" data-reveal-id="{{ $filter['modal'] }}Modal">(edit)</a>
                            		</li>
                            		@foreach($filter['values'] as $value)
										<li>
											<a class="fa-icon close" id="{{ $value['index'] }}">{{ $value['title'] }}</a>
										</li>	
									@endforeach	
                          		</ul>
                        	</li>	
						@endforeach
					</ul>
				</nav>
			</div>
			<div class="filters">
				<h3>Refine Results</h3>
				<nav>
					<ul class="side-nav">
						@foreach($remaining_filters as $filter)
							<li><a class="fa-icon plus" data-reveal-id="{{ $filter['modal'] }}Modal">{{ $filter['name'] }}</a></li>
						@endforeach
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