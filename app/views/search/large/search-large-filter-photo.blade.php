<div id="photoModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Photo Availability</h2>
	<form id="filter-by-photo">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="photo-any" value="0" checked><label for="photo-any">Any</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						<p><input type="checkbox" id="photo-1" value="1"/><label for="photo-1">Available ({{ $aggregations['price'][1]}})</label></p>
					</div>
					<div class="small-6 columns">
						<p><input type="checkbox" id="photo-2" value="4"/><label for="photo-2">Not Available ({{ $aggregations['price'][4]}})</label></p>
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