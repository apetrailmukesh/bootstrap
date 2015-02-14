<div id="certifiedModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Certification</h2>
	<form id="filter-by-certified">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="certified-any" value="0" checked><label for="certified-any">Any</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						<p><input type="checkbox" id="certified-1" value="1"/><label for="certified-1">Certified ({{ $aggregations['certified'][1]}})</label></p>
					</div>
					<div class="small-6 columns">
						<p><input type="checkbox" id="certified-2" value="2"/><label for="certified-2">Not Certified ({{ $aggregations['certified'][2]}})</label></p>
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