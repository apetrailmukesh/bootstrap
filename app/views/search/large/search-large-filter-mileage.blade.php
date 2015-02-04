<div id="mileageModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Mileage</h2>
	<form id="filter-by-mileage">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mileage-any" value="0" checked><label for="mileage-any">Any Mileage</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						<p><input type="checkbox" id="mileage-1" value="1"/><label for="mileage-1">Up to 100,000 ({{ $aggregations['price'][1]}})</label></p>
						<p><input type="checkbox" id="mileage-2" value="2"/><label for="mileage-2">100,000 - 200,000 ({{ $aggregations['price'][2]}})</label></p>
						<p><input type="checkbox" id="mileage-3" value="3"/><label for="mileage-3">200,000 - 300,000 ({{ $aggregations['price'][3]}})</label></p>
					</div>
					<div class="small-6 columns">
						<p><input type="checkbox" id="mileage-4" value="4"/><label for="mileage-4">300,000 - 400,000 ({{ $aggregations['price'][4]}})</label></p>
						<p><input type="checkbox" id="mileage-5" value="5"/><label for="mileage-5">400,000 - 500,000 ({{ $aggregations['price'][5]}})</label></p>
						<p><input type="checkbox" id="mileage-6" value="6"/><label for="mileage-6">Over 500,000 ({{ $aggregations['price'][6]}})</label></p>
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