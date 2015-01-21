@section('contents')
<header>
	@include('header')
</header>
<section>
	<!-- logo and tagline -->
	<header>
		<div class="row">
			<div class="small-12 small-centered text-center column">
				<h1 class="logo">
					<span>site</span><span>name</span><span>.com</span>
				</h1>
				<p class="tagline secondary-text">Search new &amp; used cars for sale.</p>
			</div>
		</div>
	</header>
	<!-- search bar -->
	<form>
		<div class="row">
			<div class="small-12 medium-7 large-7 columns small-centered">
				<div class="row collapse">
					<div class="small-10 medium-11 large-11 columns">
						<input type="text" class="typeahead" placeholder="Enter make, model, or style" />
					</div>
					<div class="small-2 medium-1 large-1 columns">
						<a href="srp.html" class="button postfix">GO</a>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- change location link/modal -->
	<div class="row">
		<div class="small-12 small-centered text-center column">
			<a href="#" class="fa-icon location" data-reveal-id="locationModal">{00} miles from <span>{City Name}, {ST} (change)</span></a>
			<div id="locationModal" class="reveal-modal medium location-modal" data-reveal>
				<h2>Change Location</h2>
				<form>
					<div class="row">
						<div class="small-6 medium-4 large-4 columns">
							<label>Distance
								<select>
									<option value="10">10 Miles</option>
									<option value="25">25 Miles</option>
									<option value="50" selected>50 Miles</option>
									<option value="75">75 Miles</option>
									<option value="100">100 Miles</option>
									<option value="150">150 Miles</option>
									<option value="200">200 Miles</option>
									<option value="250">250 Miles</option>
									<option value="500">500 Miles</option>
									<option value="5000">Unlimited</option>
								</select>
							</label>
						</div>
						<div class="small-6 medium-4 large-4 columns">
							<label>Zip Code
								<input type="text" placeholder="Zip Code" value="84107" />
							</label>
						</div>
						<div class="small-12 medium-4 large-4 columns">
							<label><br />
								<button type="submit" class="radius">Update</button>
							</label>
						</div>
					</div>
				</form>
				<a class="close-reveal-modal">&#215</a>
			</div>
		</div>
	</div>
	<!-- other search options -->
	<div class="row">
		<div class="small-12 small-centered text-center column">
			<p class="search-options">
				<a href="#">Advanced Search</a><a href="#">Browse by Make</a><span><a href="#">Browse by Body Style</a><a href="#">Browse by Location</a></span>
			</p>
		</div>
	</div>
</section>
@stop