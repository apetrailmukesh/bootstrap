<div class="show-for-small"> <!-- mobile filters and sort -->
	<div class="row">
		<div class="small-12 columns">
			<div class="row">
				<div class="small-7 columns">
					<a href="#" class="button radius small left-off-canvas-toggle">Refine Search</a>
				</div>
				<div class="small-5 text-right columns">
					<a href="#" data-reveal-id="mobileSort" class="button radius small">Sort</a>
					<div id="mobileSort" class="reveal-modal mobile-sort" data-reveal>
						<h2>Change Sort</h2>
						<form>
							<p><input type="radio" name="sortValue" value="price|highest" id="sortPriceHighest"><label for="sortPriceHighest">Price - Highest</label></p>
							<p><input type="radio" name="sortValue" value="price|lowest" id="sortPriceLowest"><label for="sortPriceLowest">Price - Lowest</label></p>
							<p><input type="radio" name="sortValue" value="mileage|highest" id="sortMileageHighest"><label for="sortMileageHighest">Mileage - Highest</label></p>
							<p><input type="radio" name="sortValue" value="mileage|lowest" id="sortMileageLowest"><label for="sortMileageLowest">Mileage - Lowest</label></p>
							<p><input type="radio" name="sortValue" value="year|newest" id="sortYearNewest"><label for="sortYearNewest">Year - Newest</label></p>
							<p><input type="radio" name="sortValue" value="year|oldest" id="sortYearOldest"><label for="sortYearOldest">Year - Oldest</label></p>
							<p><input type="radio" name="sortValue" value="distance|nearest" id="sortDistance"><label for="sortDistance">Distance - Nearest</label></p>
							<p><input type="radio" name="sortValue" value="makemodel|atoz" id="sortMakeModel"><label for="sortMakeModel">Make/Model - A to Z</label></p>
							<p><input type="radio" name="sortValue" value="date|newest" id="sortDate"><label for="sortDate">Date Listed - Newest</label></p>
							<button type="submit" class="radius">Update</button>
						</form>
						<a class="close-reveal-modal">&#215</a>
					</div>
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
						<li><a href="#" class="fa-icon plus" data-reveal-id="priceModalMobile">Price</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="mileageModalMobile">Mileage</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="yearModalMobile">Year</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="bodystyleModalMobile">Style</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="certificationModalMobile">Certification</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="extColorModalMobile">Exterior Color</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="intColorModalMobile">Interior Color</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="engineModalMobile">Cylinders</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="transmissionModalMobile">Transmission</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="drivetrainModalMobile">Drivetrain</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="fuelModalMobile">Fuel</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="doorCntModalMobile">Door Count</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="sellerModalMobile">Seller Type</a></li>
						<li><a href="#" class="fa-icon plus" data-reveal-id="photoModalMobile">Photos</a></li>
					</ul>
				</nav>
				<!-- filter modals -->
				<div id="priceModalMobile" class="reveal-modal medium filter-modal" data-reveal>
					<h2>Filter by Price</h2>
					<form>
						<div class="row">
							<div class="small-12 columns border">
								<input type="checkbox" id="anyPrice" value="anyPrice" checked><label for="anyPrice">Any Price {00}</label>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<p><input type="checkbox" id="5kPrice" value="5000"><label for="5kPrice">Up to $5,000 {00}</label></p>
								<p><input type="checkbox" id="10kPrice" value="10000"><label for="10kPrice">$5,001-$10,000 {00}</label></p>
								<p><input type="checkbox" id="15kPrice" value="15000"><label for="15kPrice">$10,001-$15,000 {00}</label></p>
								<p><input type="checkbox" id="20kPrice" value="20000"><label for="20kPrice">$15,001-$20,000 {00}</label></p>
								<p><input type="checkbox" id="25kPrice" value="25000"><label for="25kPrice">$20,001-$25,000 {00}</label></p>
								<p><input type="checkbox" id="30kPrice" value="30000"><label for="30kPrice">$25,001-$30,000 {00}</label></p>
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
				<div id="mileageModalMobile" class="reveal-modal medium" data-reveal>
					<h2>Filter by Mileage</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="yearModalMobile" class="reveal-modal medium" data-reveal>
					<h2>Filter by Year</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="bodystyleModalMobile" class="reveal-modal medium" data-reveal>
					<h2>Filter by Style</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="certificationModalMobile" class="reveal-modal medium" data-reveal>
					<h2>Filter by Certification</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="extColorModalMobile" class="reveal-modal medium" data-reveal>
					<h2>Filter by Exterior Color</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="intColorModalMobile" class="reveal-modal medium" data-reveal>
					<h2>Filter by Interior Color</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="engineModalMobile" class="reveal-modal medium" data-reveal>
					<h2>Filter by Cylinders</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="transmissionModalMobile" class="reveal-modal medium" data-reveal>
					<h2>Filter by Transmission</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="drivetrainModalMobile" class="reveal-modal medium" data-reveal>
					<h2>Filter by Drivetrain</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="fuelModalMobile" class="reveal-modal medium" data-reveal>
					<h2>Filter by Fuel</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="doorCntModalMobile" class="reveal-modal medium" data-reveal>
					<h2>Filter by Door Count</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="sellerModalMobile" class="reveal-modal medium" data-reveal>
					<h2>Filter by Seller Type</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
				<div id="photoModalMobile" class="reveal-modal medium" data-reveal>
					<h2>Filter by Photos</h2>
					<a class="close-reveal-modal">&#215</a>
				</div>
			</div>
		</div>
	</aside>
</div>