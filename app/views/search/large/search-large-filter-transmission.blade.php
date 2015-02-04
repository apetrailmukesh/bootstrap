<div id="transmissionModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Transmission</h2>
	<form id="filter-by-transmission">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="transmission-any" value="0" checked><label for="transmission-any">Any Transmission</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						<p><input type="checkbox" id="transmission-1" value="1"/><label for="transmission-1">Automatic ({{ $aggregations['transmission'][1]}})</label></p>
					</div>
					<div class="small-6 columns">
						<p><input type="checkbox" id="transmission-2" value="2"/><label for="transmission-2">Manual ({{ $aggregations['transmission'][2]}})</label></p>
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