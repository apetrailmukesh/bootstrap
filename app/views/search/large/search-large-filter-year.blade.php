<div id="yearModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Year</h2>
	<form id="filter-by-year">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="year-any" value="0" checked><label for="year-any">Any Year</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						<p><input type="checkbox" id="year-1" value="1"/><label for="year-1">Before 1990 ({{ $aggregations['price'][1]}})</label></p>
						<p><input type="checkbox" id="year-2" value="2"/><label for="year-2">1990 - 1995 ({{ $aggregations['price'][2]}})</label></p>
						<p><input type="checkbox" id="year-3" value="3"/><label for="year-3">1995 - 2000 ({{ $aggregations['price'][3]}})</label></p>
					</div>
					<div class="small-6 columns">
						<p><input type="checkbox" id="year-4" value="4"/><label for="year-4">2000 - 2005 ({{ $aggregations['price'][4]}})</label></p>
						<p><input type="checkbox" id="year-5" value="5"/><label for="year-5">2005 - 2010 ({{ $aggregations['price'][5]}})</label></p>
						<p><input type="checkbox" id="year-6" value="6"/><label for="year-6">After 2010 ({{ $aggregations['price'][6]}})</label></p>
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