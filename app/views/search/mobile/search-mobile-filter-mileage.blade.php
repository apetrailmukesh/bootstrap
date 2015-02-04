<div id="mobileMileageModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Mileage</h2>
	<form id="mobile-filter-by-mileage">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-mileage-any" value="0" checked><label for="mobile-mileage-any">Any Mileage</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<p><input type="checkbox" id="mobile-mileage-1" value="1"/><label for="mobile-mileage-1">Up to 100,000 ({{ $aggregations['mileage'][1]}})</label></p>
				<p><input type="checkbox" id="mobile-mileage-2" value="2"/><label for="mobile-mileage-2">100,000 - 200,000 ({{ $aggregations['mileage'][2]}})</label></p>
				<p><input type="checkbox" id="mobile-mileage-3" value="3"/><label for="mobile-mileage-3">200,000 - 300,000 ({{ $aggregations['mileage'][3]}})</label></p>
				<p><input type="checkbox" id="mobile-mileage-4" value="4"/><label for="mobile-mileage-4">300,000 - 400,000 ({{ $aggregations['mileage'][4]}})</label></p>
				<p><input type="checkbox" id="mobile-mileage-5" value="5"/><label for="mobile-mileage-5">400,000 - 500,000 ({{ $aggregations['mileage'][5]}})</label></p>
				<p><input type="checkbox" id="mobile-mileage-6" value="6"/><label for="mobile-mileage-6">Over 500,000 ({{ $aggregations['mileage'][6]}})</label></p>
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