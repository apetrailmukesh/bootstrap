<div id="priceModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Price</h2>
	<form id="filter-by-price">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="price-any" value="0" checked><label for="price-any">Any Price</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						<p><input type="checkbox" id="price-1" value="1"/><label for="price-1">Up to $10,000 ({{ $aggregations['price'][1]}})</label></p>
						<p><input type="checkbox" id="price-2" value="2"/><label for="price-2">$10,000 - $20,000 ({{ $aggregations['price'][2]}})</label></p>
						<p><input type="checkbox" id="price-3" value="3"/><label for="price-3">$20,000 - $30,000 ({{ $aggregations['price'][3]}})</label></p>
					</div>
					<div class="small-6 columns">
						<p><input type="checkbox" id="price-4" value="4"/><label for="price-4">$30,000 - $40,000 ({{ $aggregations['price'][4]}})</label></p>
						<p><input type="checkbox" id="price-5" value="5"/><label for="price-5">$40,000 - $50,000 ({{ $aggregations['price'][5]}})</label></p>
						<p><input type="checkbox" id="price-6" value="6"/><label for="price-6">Over $50,000 ({{ $aggregations['price'][6]}})</label></p>
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