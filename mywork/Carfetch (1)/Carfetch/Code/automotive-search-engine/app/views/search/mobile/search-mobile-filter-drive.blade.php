<div id="mobileDriveModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Drivetrain</h2>
	<form id="mobile-filter-by-drive">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="mobile-drive-any" value="0" checked><label for="mobile-drive-any">Any Drivetrain</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				@foreach($aggregations['drive'] as $drive)
					<p><input type="checkbox" id="mobile-drive-{{$drive['key']}}" value="{{$drive['key']}}"/><label for="mobile-drive-{{$drive['key']}}">{{ $drive['title'] }}</label></p>
				@endforeach
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