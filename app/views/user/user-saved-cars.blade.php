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
				<li class="tab-title active"><a href="/user/saved/cars"><span class="hide-for-small-only">Saved </span>Cars<span class="hide-for-small-only count"> (0)</span></a></li>
				<li class="tab-title"><a href="/user/saved/searches"><span class="hide-for-small-only">Saved </span>Searches<span class="hide-for-small-only count"> (0)</span></a></li>
			</ul>
		</div>
	</div>
	<div class="content favorites-div">
		<div class="show-for-small row">
			<div class="small-7 columns">
				<h2>{00} Saved Cars</h2>
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
				<h2>{00} Saved Cars</h2>
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
			@for ($i = 0; $i < 5; $i++)
			<div class="small-12 medium-6 columns card-wrapper" data-equalizer-watch>
				<div class="vehicle-card">
					<div class="show-for-small row">
						<div class="small-6 columns">
							<a href="#" class="fa-icon share">Share</a>
						</div>
						<div class="small-6 text-right columns">
							<span class="fa-icon remove">Remove</span>
						</div>
					</div>
					<div class="row">
						<div class="small-12 medium-8 columns">
							<h3><a href="#">{InvType} {Year} {Make} {Model} {Trim}</a></h3>
						</div>
						<div class="hide-for-small medium-4 text-right columns">
							<span class="fa-icon remove">Remove</span>
						</div>
					</div>
					<div class="row">
						<div class="small-12 medium-4 columns">
							<img src="images/vehicle-01.png" title="{YYYY} {Make} {Model} {Trim}">
							<a href="#" class="fa-icon share hide-for-small text-center">Share</a>
						</div>
						<div class="small-12 medium-8 columns">
							<p><span class="price"><strong>${00,000}</strong></span> {00,000} mi.</p>
							<p class="small secondary-text">{Color}, {# of doors}, {Drivetrain}, {Body Style}, {Transmission}, {Engine}, {Stock # 00000000}</p>
							<p><strong>{Dealership Name}</strong> <span class="secondary-text">in {City Name}, {ST} ~ {00} mi. away</span></p>
						</div>
					</div>
				</div>
			</div>
			@endfor
		</div>
	</div>
</section>
@stop