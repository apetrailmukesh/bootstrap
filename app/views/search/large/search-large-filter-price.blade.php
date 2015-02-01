<div id="priceModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Price</h2>
	<form id="filter-by-price">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="any" value="any" checked><label for="anyPrice">Any Price</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						<p><input type="checkbox" id="price-1" value="1"><label for="5kPrice">Up to $10,000 ({{ $prices['1'] }})</label></p>
						<p><input type="checkbox" id="price-2" value="2"><label for="10kPrice">$10,100 - $20,000 ({{ $prices['2'] }})</label></p>
						<p><input type="checkbox" id="price-3" value="3"><label for="15kPrice">$20,000 - $30,000 ({{ $prices['3'] }})</label></p>
					</div>
					<div class="small-6 columns">
						<p><input type="checkbox" id="price-4" value="4"><label for="20kPrice">$30,000 - $40,000 ({{ $prices['4'] }})</label></p>
						<p><input type="checkbox" id="price-5" value="5"><label for="25kPrice">$40,000 - $50,000 ({{ $prices['5'] }})</label></p>
						<p><input type="checkbox" id="price-6" value="6"><label for="30kPrice">Over $50,000 ({{ $prices['6'] }})</label></p>
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