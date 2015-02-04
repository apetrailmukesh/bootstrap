<div id="mobileTransmissionModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Transmission</h2>
	<form id="mobile-filter-by-transmission">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-transmission-any" value="0" checked><label for="mobile-transmission-any">Any Transmission</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<p><input type="checkbox" id="mobile-transmission-1" value="1"/><label for="mobile-transmission-1">Automatic ({{ $aggregations['transmission'][1]}})</label></p>
				<p><input type="checkbox" id="mobile-transmission-2" value="2"/><label for="mobile-transmission-2">Manual ({{ $aggregations['transmission'][2]}})</label></p>
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