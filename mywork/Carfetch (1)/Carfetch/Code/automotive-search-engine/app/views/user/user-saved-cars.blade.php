@section('contents')
<header>
	@include('header')
	@include('search/search-header')
</header>
<section role="main">
	<header>
		<div class="row">
			<div class="small-12 columns">
				<h1>Favorites</h1>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="small-12 columns">
			<ul class="tabs">
				<li class="tab-title active"><a href="/user/saved/cars"><span class="hide-for-small-only">Saved </span>Cars<span class="hide-for-small-only count"> ({{ $saved_car_count }})</span></a></li>
				<li class="tab-title"><a href="/user/saved/searches"><span class="hide-for-small-only">Saved </span>Searches<span class="hide-for-small-only count"> ({{ $saved_search_count }})</span></a></li>
			</ul>
		</div>
	</div>
	<div class="content favorites-div">
		<div class="show-for-small row">
			<div class="small-7 columns">
				<h2>{{ $saved_car_count }} Saved Cars</h2>
			</div>
			<div class="small-5 text-right columns">
				<a data-reveal-id="mobileSavedCarsSort" class="button radius small">Sort</a>
				<div id="mobileSavedCarsSort" class="reveal-modal mobile-sort" data-reveal>
					<h2>Change Sort</h2>
					<form class="mobile-sort-form">
						<p><input type="radio" value="date-1" id="date-1" name="sort-options"><label for="date-1">Date Added - Newest</label></p>
						<p><input type="radio" value="date-0" id="date-0" name="sort-options"><label for="date-0">Date Added - Oldest</label></p>
						<p><input type="radio" value="price-1" id="price-1" name="sort-options"><label for="price-1">Price - Highest</label></p>
						<p><input type="radio" value="price-0" id="price-0" name="sort-options"><label for="price-0">Price - Lowest</label></p>
						<p><input type="radio" value="miles-1" id="mileage-1" name="sort-options"><label for="miles-1">Mileage - Highest</label></p>
						<p><input type="radio" value="miles-0" id="mileage-0" name="sort-options"><label for="miles-0">Mileage - Lowest</label></p>
						<p><input type="radio" value="year-1" id="year-1" name="sort-options"><label for="year-1">Year - Newest</label></p>
						<p><input type="radio" value="year-0" id="year-0" name="sort-options"><label for="year-0">Year - Oldest</label></p>
						<button type="submit" class="radius">Update</button>
					</form>
					<a class="close-reveal-modal">&#215</a>
				</div>
			</div>
		</div>
		<div class="hide-for-small row">
			<div class="medium-7 large-8 columns">
				<h2>{{ $saved_car_count }} Saved Cars</h2>
			</div>
			<div class="medium-5 large-4 columns">
				<form>
					<div class="row favourite-sort">
						<div class="small-4 columns">
							<label for="sort" class="right inline">Sort by</label>
						</div>
						<div class="small-8 columns no-left-pad">
							<select id="large-sort" class="small">
								<option value="date-1" selected>Date Added - Newest</option>
								<option value="date-0">Date Added - Oldest</option>
								<option value="price-1">Price - Highest</option>
								<option value="price-0">Price - Lowest</option>
								<option value="mileage-1">Mileage - Highest</option>
								<option value="mileage-0">Mileage - Lowest</option>
								<option value="year-1">Year - Newest</option>
								<option value="year-0">Year - Oldest</option>
							</select>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row" data-equalizer>
			@foreach ($results as $result)
			<div class="small-12 medium-6 columns card-wrapper" data-equalizer-watch>
				<div class="vehicle-card">
					<div class="show-for-small row">
						<div class="small-6 columns">
						</div>
						<div class="small-6 text-right columns">
							<span class="fa-icon remove" id="saved-vehicle-remove-{{$result['vin']}}">Remove</span>
						</div>
					</div>
					<div class="row">
						<div class="small-12 medium-8 columns">
							<h3><a href="/vehicle/?vin={{ $result['vin'] }}">{{ $result['year'] }} {{ $result['make'] }} {{ $result['model'] }} {{ $result['trim'] }}</a></h3>
						</div>
						<div class="hide-for-small medium-4 text-right columns">
							<span class="fa-icon remove" id="saved-vehicle-remove-{{$result['vin']}}">Remove</span>
						</div>
					</div>
					<div class="row">
						<div class="small-12 medium-4 columns">
							<img src="{{ $result['image'] }}" title="{{ $result['year'] }} {{ $result['make'] }} {{ $result['model'] }}">
						</div>
						<div class="small-12 medium-8 columns">
							<p><span class="price"><strong>{{ $result['price'] }}</strong></span>{{ $result['mileage'] }}</p>
							<p class="small secondary-text">{{ $result['trim'] }} {{ $result['transmission'] }} {{ $result['body'] }} {{ $result['feature'] }} {{ $result['drive'] }}</p>
							<p><strong>{{ $result['dealer'] }}</strong> <span class="secondary-text">{{ $result['dealer_address'] }}</span></p>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>
@stop