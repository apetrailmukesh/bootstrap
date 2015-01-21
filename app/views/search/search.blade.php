@section('contents')
<div class="marketing off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">
		<header>
			@include('header')
			<!-- logo and search bar section -->
			<div class="hide-for-small search-bkgrd"> <!-- show for everything 640px and above -->
				<div class="row">
					<div class="small-3 columns">
						<h1 class="logo">
							<span>site</span><span>name</span><span>.com</span>
						</h1>
					</div>
					<div class="small-9 columns">
						<div class="row collapse">
							<div class="small-10 medium-11 large-11 columns">
								<input type="text" class="typeahead" placeholder="{{ $search_text }}" />
							</div>
							<div class="small-2 medium-1 large-1 columns">
								<a href="index.html" class="button postfix">GO</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="show-for-small search-bkgrd"> <!-- mobile version -->
				<div class="row">
					<div class="small-10 columns">
						<h1 class="logo">
							<span>site</span><span>name</span><span>.com</span>
						</h1>
					</div>
					<div class="small-2 text-right columns">
						<span class="fa-icon search" id="open-mobile-search"></span>
					</div>
				</div>
				<div class="row not-visible" id="mobile-search-box">
					<div class="small-12 column small-centered">
						<div class="row collapse">
							<div class="small-10 columns">
								<input type="text" class="typeahead" placeholder="Start new search" />
							</div>
							<div class="small-2 columns">
								<a href="index.html" class="button postfix">GO</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		<section role="main">
			<header>
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
				<div class="row">
					<div class="small-12 columns">
						<h1>{InvType} {Make} {Model} for sale near {City Name}, {ST}</h1>
					</div>
				</div>
				<div class="row">
					<div class="small-12 medium-8 large-9 columns">
						<p class="location-change">We found <strong>{00} cars for sale</strong> within <a href="#" data-reveal-id="locationModal"><strong>{00} miles from {City Name}, {ST}</strong> (change)</a></p>
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
					<div class="medium-4 large-3 columns">
						<div class="hide-for-small">
							<form>
								<div class="row">
									<div class="small-4 columns">
										<label for="sort" class="right inline">Sort by</label>
									</div>
									<div class="small-8 columns no-left-pad">
										<select id="sort" class="small">
											<option value="price|highest" selected>Price - Highest</option>
											<option value="price|lowest">Price - Lowest</option>
											<option value="mileage|highest">Mileage - Highest</option>
											<option value="mileage|lowest">Mileage - Lowest</option>
											<option value="year|newest">Year - Newest</option>
											<option value="year|oldest">Year - Oldest</option>
											<option value="distance|nearest">Distance - Nearest</option>
											<option value="makemodel|atoz">Make/Model - A to Z</option>
											<option value="date|newest">Date Listed - Newest</option>
										</select>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</header>
			<div class="row">
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
				<div class="large-9 medium-8 columns">
					<div class="row">
						<div class="small-12 columns">
							<p class="secondary-text subhead"><strong>FEATURED VEHICLES</strong></p>
						</div>
					</div>
					<!-- vehicle listing -->
					<article class="vehicle">
						<div class="row">
							<div class="small-12 columns">
								<h2><a href="#">{YYYY} {Make} {Model} {Trim}</a></h2>
								<p class="small secondary-text">{longform link to vehicle detail page here - this is not clickable}</p>
							</div>
						</div>
						<div class="row" data-equalizer>
							<div class="small-5 medium-3 large-3 columns" data-equalizer-watch>
								<img src="images/vehicle-01.png" title="{YYYY} {Make} {Model} {Trim}">
								<p>
									<a href="#" class="fa-icon save">Save</a>
									<a href="#" class="fa-icon share">Share</a>
								</p>
							</div>
							<div class="small-7 medium-9 large-9 columns" data-equalizer-watch>
								<p><span class="price"><strong>${00,000}</strong></span> {00,000} mi.</p>
								<p>{Color}, {# of doors}, {Drivetrain}, {Body Style}, {Transmission}, {Engine}, {Stock # 00000000}</p>
								<p class="detailed-description secondary-text hide-for-small">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris molestie vehicula ex vel dignissim. Morbi auctor tellus placerat tortor ultricies varius....<a href="#">Read More</a></p>
								<p><strong>{Dealership Name}</strong> <span class="secondary-text">in {City Name}, {ST} ~ {00} mi. away</span></p>
							</div>
						</article>
						<!-- vehicle listing -->
						<article class="vehicle">
							<div class="row">
								<div class="small-12 columns">
									<h2><a href="#">{YYYY} {Make} {Model} {Trim}</a></h2>
									<p class="small secondary-text">{longform link to vehicle detail page here - this is not clickable}</p>
								</div>
							</div>
							<div class="row" data-equalizer>
								<div class="small-5 medium-3 large-3 columns" data-equalizer-watch>
									<img src="images/vehicle-02.png" title="{YYYY} {Make} {Model} {Trim}">
									<p>
										<a href="#" class="fa-icon save">Save</a>
										<a href="#" class="fa-icon share">Share</a>
									</p>
								</div>
								<div class="small-7 medium-9 large-9 columns" data-equalizer-watch>
									<p><span class="price"><strong>${00,000}</strong></span> {00,000} mi.</p>
									<p>{Color}, {# of doors}, {Drivetrain}, {Body Style}, {Transmission}, {Engine}, {Stock # 00000000}</p>
									<p class="detailed-description secondary-text hide-for-small">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris molestie vehicula ex vel dignissim. Morbi auctor tellus placerat tortor ultricies varius....<a href="#">Read More</a></p>
									<p><strong>{Dealership Name}</strong> <span class="secondary-text">in {City Name}, {ST} ~ {00} mi. away</span></p>
								</div>
							</article>
							<!-- vehicle listing -->
							<article class="vehicle">
								<div class="row">
									<div class="small-12 columns">
										<h2><a href="#">{YYYY} {Make} {Model} {Trim}</a></h2>
										<p class="small secondary-text">{longform link to vehicle detail page here - this is not clickable}</p>
									</div>
								</div>
								<div class="row" data-equalizer>
									<div class="small-5 medium-3 large-3 columns" data-equalizer-watch>
										<img src="images/vehicle-03.png" title="{YYYY} {Make} {Model} {Trim}">
										<p>
											<a href="#" class="fa-icon save">Save</a>
											<a href="#" class="fa-icon share">Share</a>
										</p>
									</div>
									<div class="small-7 medium-9 large-9 columns" data-equalizer-watch>
										<p><span class="price"><strong>${00,000}</strong></span> {00,000} mi.</p>
										<p>{Color}, {# of doors}, {Drivetrain}, {Body Style}, {Transmission}, {Engine}, {Stock # 00000000}</p>
										<p class="detailed-description secondary-text hide-for-small">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris molestie vehicula ex vel dignissim. Morbi auctor tellus placerat tortor ultricies varius....<a href="#">Read More</a></p>
										<p><strong>{Dealership Name}</strong> <span class="secondary-text">in {City Name}, {ST} ~ {00} mi. away</span></p>
									</div>
								</article>
								<!-- vehicle listing -->
								<article class="vehicle">
									<div class="row">
										<div class="small-12 columns">
											<h2><a href="#">{YYYY} {Make} {Model} {Trim}</a></h2>
											<p class="small secondary-text">{longform link to vehicle detail page here - this is not clickable}</p>
										</div>
									</div>
									<div class="row" data-equalizer>
										<div class="small-5 medium-3 large-3 columns" data-equalizer-watch>
											<img src="images/vehicle-04.png" title="{YYYY} {Make} {Model} {Trim}">
											<p>
												<a href="#" class="fa-icon save">Save</a>
												<a href="#" class="fa-icon share">Share</a>
											</p>
										</div>
										<div class="small-7 medium-9 large-9 columns" data-equalizer-watch>
											<p><span class="price"><strong>${00,000}</strong></span> {00,000} mi.</p>
											<p>{Color}, {# of doors}, {Drivetrain}, {Body Style}, {Transmission}, {Engine}, {Stock # 00000000}</p>
											<p class="detailed-description secondary-text hide-for-small">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris molestie vehicula ex vel dignissim. Morbi auctor tellus placerat tortor ultricies varius....<a href="#">Read More</a></p>
											<p><strong>{Dealership Name}</strong> <span class="secondary-text">in {City Name}, {ST} ~ {00} mi. away</span></p>
										</div>
									</article>
									<div class="row">
										<div class="pagination-centered">
											<ul class="pagination">
												<li class="arrow unavailable"><a href="">&laquo;</a></li>
												<li class="current"><a href="">1</a></li>
												<li><a href="">2</a></li>
												<li><a href="">3</a></li>
												<li><a href="">4</a></li>
												<li class="unavailable"><a href="">&hellip;</a></li>
												<li><a href="">12</a></li>
												<li><a href="">13</a></li>
												<li class="arrow"><a href="">&raquo;</a></li>
											</ul>
										</div>
									</div>
								</div>
							</section>
							<!-- close the off-canvas/mobile filters -->
							<a class="exit-off-canvas"></a>
						</div>
					</div>
					@stop