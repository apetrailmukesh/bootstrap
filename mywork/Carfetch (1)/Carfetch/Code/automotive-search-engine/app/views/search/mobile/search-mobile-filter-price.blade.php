<div id="mobilePriceModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Price</h2>
	<ul class="tabs" data-tab>
		<li class="tab-title active"><a href="#basicPriceMobile">Basic</a></li>
		<li class="tab-title"><a href="#customPriceMobile">Custom</a></li>
	</ul>
	<form id="mobile-filter-by-price">		
		<div class="tabs-content">
			<div class="content active" id="basicPriceMobile">
				<div class="row">
					<div class="small-12 columns border">
						<input type="checkbox" id="mobile-price-any" value="0" checked><label for="mobile-price-any">Any Price</label>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<div class="row">
							<div class="small-12 columns">
								<p><input type="checkbox" id="mobile-price-1" value="1"/><label for="mobile-price-1">Up to $5,000 ({{ $aggregations['price'][1]}})</label></p>
								<p><input type="checkbox" id="mobile-price-2" value="2"/><label for="mobile-price-2">$5,001 - $10,000 ({{ $aggregations['price'][2]}})</label></p>
								<p><input type="checkbox" id="mobile-price-3" value="3"/><label for="mobile-price-3">$10,001 - $15,000 ({{ $aggregations['price'][3]}})</label></p>
								<p><input type="checkbox" id="mobile-price-4" value="4"/><label for="mobile-price-4">$15,001 - $20,000 ({{ $aggregations['price'][4]}})</label></p>
								<p><input type="checkbox" id="mobile-price-5" value="5"/><label for="mobile-price-5">$20,001 - $30,000 ({{ $aggregations['price'][5]}})</label></p>
								<p><input type="checkbox" id="mobile-price-6" value="6"/><label for="mobile-price-6">$30,001 - $40,000 ({{ $aggregations['price'][6]}})</label></p>
								<p><input type="checkbox" id="mobile-price-7" value="7"/><label for="mobile-price-7">$40,001 - $50,000 ({{ $aggregations['price'][7]}})</label></p>
								<p><input type="checkbox" id="mobile-price-8" value="8"/><label for="mobile-price-8">Over $50,000 ({{ $aggregations['price'][8]}})</label></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="content" id="customPriceMobile">
				<div class="row">
					<div class="small-7 medium-6 columns">
						<label><strong>Min Price</strong></label>
						<input type="text" class="priceMin"/>
					</div>
					<div class="small-7 medium-6 columns end">
						<label><strong>Max Price</strong></label>
						<input type="text" class="priceMax"/>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="small 12 columns">
				<button type="submit" class="radius">Update Results</button>
				<a class="close-reveal-modal cancel">Cancel</a>
			</div>
		</div>              
	</form>
	<a class="close-reveal-modal">&#215</a>
</div>