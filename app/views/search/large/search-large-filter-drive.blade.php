<div id="driveModal" class="reveal-modal medium filter-modal" data-reveal>
	<h2>Filter by Drivetrain</h2>
	<form id="filter-by-drive">
		<div class="row">
			<div class="small-12 columns border">
				<input type="checkbox" id="drive-any" value="0" checked><label for="drive-any">Any Drivetrain</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 columns">
						@foreach($aggregations['drive'] as $drive)
							@if($drive['index']%2 === 0)
								<p><input type="checkbox" id="drive-{{$drive['key']}}" value="{{$drive['key']}}"/><label for="drive-{{$drive['key']}}">{{ $drive['title'] }}</label></p>
							@endif
						@endforeach
					</div>
					<div class="small-6 columns">
						@foreach($aggregations['drive'] as $drive)
							@if($drive['index']%2 === 1)
								<p><input type="checkbox" id="drive-{{$drive['key']}}" value="{{$drive['key']}}"/><label for="drive-{{$drive['key']}}">{{ $drive['title'] }}</label></p>
							@endif
						@endforeach
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