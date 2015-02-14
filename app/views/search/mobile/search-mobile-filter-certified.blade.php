<div id="mobileCertifiedModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Certification</h2>
	<form id="mobile-filter-by-certified">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-certified-any" value="0" checked><label for="mobile-certified-any">Any</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<p><input type="checkbox" id="mobile-certified-1" value="1"/><label for="mobile-certified-1">Certified ({{ $aggregations['certified'][1]}})</label></p>
				<p><input type="checkbox" id="mobile-certified-2" value="2"/><label for="mobile-certified-2">Not Certified ({{ $aggregations['certified'][2]}})</label></p>
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