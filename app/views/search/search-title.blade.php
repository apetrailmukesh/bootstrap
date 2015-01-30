<div class="row">
	<div class="small-12 columns">
		<h1>{{ $title }}</h1>
	</div>
</div>
<div class="row">
	<div class="small-12 medium-8 large-9 columns">
		<p class="location-change">We found <strong>{{ $total }} cars for sale</strong> within <a href="#" data-reveal-id="locationModal"><strong>{{ $location_info }}</strong> (change)</a></p>
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
	@include('search/search-large-sort')
</div>