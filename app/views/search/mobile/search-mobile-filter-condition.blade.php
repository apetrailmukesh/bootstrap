<div id="mobileConditionModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Condition</h2>
	<form id="mobile-filter-by-condition">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-condition-any" value="0" checked><label for="mobile-condition-any">Any</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<p><input type="checkbox" id="mobile-condition-1" value="1"/><label for="mobile-condition-1">New ({{ $aggregations['condition'][1]}})</label></p>
				<p><input type="checkbox" id="mobile-condition-2" value="2"/><label for="mobile-condition-2">Used ({{ $aggregations['condition'][2]}})</label></p>
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