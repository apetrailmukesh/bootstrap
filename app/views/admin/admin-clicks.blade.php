@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	<div class="row">
		<div class="small-12 medium-7 large-7 columns small-centered">
			<div class="panel callout radius">
				<p class="tagline secondary-text">Vehicle Clicks</p>
				<table width="100%">
					<thead>
						<tr>
							<th width="30%" class="number-column">VIN</th>
							<th width="30%" class="number-column">Date</th>
							<th width="25%" class="number-column">IP Address</th>
							<th width="15%" class="number-column">Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($clicks as $click)
							<tr>
								<td class="number-column">{{ $click->vin }}</td>
								<td class="number-column">{{ $click->datetime }}</td>
								<td class="number-column">{{ $click->ip }}</td>
								<td class="number-column">{{ $click->paid == 0 ? 'Free' : 'Paid' }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
	    <div class="pagination-centered">
			<ul id="click-pagination">
			</ul>
		</div>
	</div>
	<input type="hidden" name="total_results" id="total_results" value="{{ $total }}" />
</section>
@stop