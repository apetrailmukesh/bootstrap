<div id="mobilePhotoModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Photo Availability</h2>
	<form id="mobile-filter-by-photo">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-photo-any" value="0" checked><label for="mobile-photo-any">Any</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<p><input type="checkbox" id="mobile-photo-1" value="1"/><label for="mobile-photo-1">Available ({{ $aggregations['photo'][1]}})</label></p>
				<p><input type="checkbox" id="mobile-photo-2" value="2"/><label for="mobile-photo-2">Not Available ({{ $aggregations['photo'][2]}})</label></p>
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