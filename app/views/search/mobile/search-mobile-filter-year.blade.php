<div id="mobileYearModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Year</h2>
	<form id="mobile-filter-by-year">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-year-any" value="0" checked><label for="mobile-year-any">Any Year</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<p><input type="checkbox" id="mobile-year-1" value="1"/><label for="mobile-year-1">Before 1990 ({{ $aggregations['price'][1]}})</label></p>
				<p><input type="checkbox" id="mobile-year-2" value="2"/><label for="mobile-year-2">1990 - 1995 ({{ $aggregations['price'][2]}})</label></p>
				<p><input type="checkbox" id="mobile-year-3" value="3"/><label for="mobile-year-3">1995 - 2000 ({{ $aggregations['price'][3]}})</label></p>
				<p><input type="checkbox" id="mobile-year-4" value="4"/><label for="mobile-year-4">2000 - 2005 ({{ $aggregations['price'][4]}})</label></p>
				<p><input type="checkbox" id="mobile-year-5" value="5"/><label for="mobile-year-5">2005 - 2010 ({{ $aggregations['price'][5]}})</label></p>
				<p><input type="checkbox" id="mobile-year-6" value="6"/><label for="mobile-year-6">After 2010 ({{ $aggregations['price'][6]}})</label></p>
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