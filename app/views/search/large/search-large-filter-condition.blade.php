<div id="conditionModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Condition</h2>
	<form id="filter-by-condition">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="condition-any" value="0" checked><label for="condition-any">Any</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						<p><input type="checkbox" id="condition-1" value="1"/><label for="condition-1">New ({{ $aggregations['condition'][1]}})</label></p>
					</div>
					<div class="small-6 columns">
						<p><input type="checkbox" id="condition-2" value="2"/><label for="condition-2">Used ({{ $aggregations['condition'][2]}})</label></p>
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