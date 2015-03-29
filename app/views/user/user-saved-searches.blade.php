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
				<li class="tab-title"><a href="/user/saved/cars"><span class="hide-for-small-only">Saved </span>Cars<span class="hide-for-small-only count"> ({{ $saved_car_count }})</span></a></li>
				<li class="tab-title active"><a href="/user/saved/searches"><span class="hide-for-small-only">Saved </span>Searches<span class="hide-for-small-only count"> ({{ $saved_search_count }})</span></a></li>
			</ul>
		</div>
	</div>
	<div class="content favorites-div">
		<div class="show-for-small row">
			<div class="small-7 columns">
				<h2>{{ $saved_search_count }} Saved Searches</h2>
			</div>
			<div class="small-5 text-right columns">
				<a href="#" data-reveal-id="mobileSavedSearchesSort" class="button radius small">Sort</a>
				<div id="mobileSavedSearchesSort" class="reveal-modal mobile-sort" data-reveal>
					<h2>Change Sort</h2>
					<form class="mobile-sort-form">
						<p><input type="radio" value="date-1" id="date-1" name="sort-options"><label for="date-1">Date Added - Newest</label></p>
						<p><input type="radio" value="date-0" id="date-0" name="sort-options"><label for="date-0">Date Added - Oldest</label></p>
						<button type="submit" class="radius">Update</button>
					</form>
					<a class="close-reveal-modal">&#215</a>
				</div>
			</div>
		</div>
		<div class="hide-for-small row">
			<div class="medium-7 large-8 columns">
				<h2>{{ $saved_search_count }} Saved Searches</h2>
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
							</select>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row" data-equalizer>
			@foreach ($results as $result)
			<div class="small-12 medium-6 columns card-wrapper" data-equalizer-watch>
				<div class="search-card">
					<div class="show-for-small row">
						<div class="small-12 columns text-right">
							<span class="fa-icon remove" id="saved-search-remove-{{$result['id']}}">Remove</span>
						</div>
					</div>
					<div class="row">
						<div class="small-12 medium-9 columns">
							<h3><a href="{{ $result['query'] }}">{{ $result['title'] }}</a></h3>
						</div>
						<div class="small-12 hide-for-small medium-3 text-right columns">
							<span class="fa-icon remove" id="saved-search-remove-{{$result['id']}}">Remove</span>
						</div>
					</div>
					<div class="row">
						<div class="small-12 columns">
							<p>{{ $result['filter'] }}</p>
							<p class="small secondary-text">{{ $result['location'] }}</p>
						</div>
					</div>
					<div class="row">
						<div class="small-12 medium-7 columns">
							<a href="{{ $result['query'] }}" class="button radius">Search</a>
						</div>
						<div class="small-12 medium-5 columns">
							<p class="small secondary-text date">{{ $result['time'] }}</p>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>
@stop