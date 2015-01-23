@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	<div class="row">
		<div class="small-12 medium-7 large-7 columns small-centered">
			<div class="row collapse">
				<div class="small-10 medium-11 large-11 columns">
					@if(Session::has('message'))
						<p class="alert">{{ Session::get('message') }}</p>
					@endif
					{{ HTML::linkRoute('get.admin.specifications.add', 'ADD SPECIFICATION TYPE', array(), array('class' => 'button postfix')) }}
					<table width="100%">
						<thead>
							<tr>
								<th width="25%">Name</th>
								<th width="25%">TYPE</th>
								<th width="25%">Display</th>
								<th width="25%">Enabled</th>
							</tr>
						</thead>
						<tbody>
							@foreach($specification_types->all() as $specification_type)
								<tr>
									<td>{{ $specification_type->name }}</td>
									<td>{{ $specification_type->type }}</td>
									<td>{{ $specification_type->display }}</td>
									<td>{{ $specification_type->enabledString() }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@stop