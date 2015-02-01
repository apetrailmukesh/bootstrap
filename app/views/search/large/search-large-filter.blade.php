<div class="large-3 medium-4 columns">
	<div class="hide-for-small"> <!-- filters for medium and up screensizes -->
		<div class="sidebar">
			<div class="filters-selected">
				<h3>Your Search</h3>
				<nav>
					<ul class="side-nav">
						<li><a href="#" class="fa-icon close">{Selected Filter}</a></li>
						<li><a href="#" class="fa-icon close">{Selected Filter}</a></li>
						<li><a href="#" class="fa-icon close">{Selected Filter}</a></li>
					</ul>
				</nav>
				<a href="#" class="button radius">Save Search</a>
				<p>
					<a href="#" class="fa-icon email-alerts">Get Email Alerts</a>
					<span class="secondary-text">when we find new vehicles that match this search</span>
				</p>
			</div>
			<div class="filters">
				<h3>Refine Results</h3>
				<nav>
					<ul class="side-nav">
						<li><a href="#" class="fa-icon plus" data-reveal-id="priceModal">Price</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="mileageModal">Mileage</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="yearModal">Year</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="bodystyleModal">Style</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="certificationModal">Certification</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="extColorModal">Exterior Color</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="intColorModal">Interior Color</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="engineModal">Cylinders</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="transmissionModal">Transmission</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="drivetrainModal">Drivetrain</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="fuelModal">Fuel</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="doorCntModal">Door Count</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="sellerModal">Seller Type</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="photoModal">Photos</a></li>
					</ul>
				</nav>
				<!-- filter modals -->
				<div id="priceModal" class="reveal-modal medium filter-modal" data-reveal>
					<h2>Filter by Price</h2>
					<form>
						<div class="row">
							<div class="small-12 columns border">
								<input type="checkbox" id="anyPrice" value="anyPrice" checked><label for="anyPrice">Any Price {00}</label>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-6 columns">
										<p><input type="checkbox" id="5kPrice" value="5000"><label for="5kPrice">Up to $5,000 {00}</label></p>
										<p><input type="checkbox" id="10kPrice" value="10000"><label for="10kPrice">$5,001-$10,000 {00}</label></p>
										<p><input type="checkbox" id="15kPrice" value="15000"><label for="15kPrice">$10,001-$15,000 {00}</label></p>
									</div>
									<div class="small-6 columns">
										<p><input type="checkbox" id="20kPrice" value="20000"><label for="20kPrice">$15,001-$20,000 {00}</label></p>
										<p><input type="checkbox" id="25kPrice" value="25000"><label for="25kPrice">$20,001-$25,000 {00}</label></p>
										<p><input type="checkbox" id="30kPrice" value="30000"><label for="30kPrice">$25,001-$30,000 {00}</label></p>
									</div>
								</div>
								<div class="row">
									<div class="small 12 columns">
										<button type="submit" class="radius">Update Results</button>
										<a class="close-reveal-modal cancel">Cancel</a>
									</div>
								</div>
							</div>
						</div>
					</form>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="mileageModal" class="reveal-modal medium" data-reveal>
					<h2>Filter by Mileage</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="yearModal" class="reveal-modal medium" data-reveal>
					<h2>Filter by Year</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="bodystyleModal" class="reveal-modal medium" data-reveal>
					<h2>Filter by Style</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="certificationModal" class="reveal-modal medium" data-reveal>
					<h2>Filter by Certification</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="extColorModal" class="reveal-modal medium" data-reveal>
					<h2>Filter by Exterior Color</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="intColorModal" class="reveal-modal medium" data-reveal>
					<h2>Filter by Interior Color</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="engineModal" class="reveal-modal medium" data-reveal>
					<h2>Filter by Cylinders</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="transmissionModal" class="reveal-modal medium" data-reveal>
					<h2>Filter by Transmission</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="drivetrainModal" class="reveal-modal medium" data-reveal>
					<h2>Filter by Drivetrain</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="fuelModal" class="reveal-modal medium" data-reveal>
					<h2>Filter by Fuel</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="doorCntModal" class="reveal-modal medium" data-reveal>
					<h2>Filter by Door Count</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="sellerModal" class="reveal-modal medium" data-reveal>
					<h2>Filter by Seller Type</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="photoModal" class="reveal-modal medium" data-reveal>
					<h2>Filter by Photos</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
			</div>
		</div>
	</div>
</div>