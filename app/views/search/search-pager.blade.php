@if($total > 0)
	<div class="row">
	    <div class="pagination-centered">
			<div id="pagination">
			</div>
		</div>
	</div>
	<input type="hidden" name="total_results" id="total_results" value="{{ $total }}" />
@endif