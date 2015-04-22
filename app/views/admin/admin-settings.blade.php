@section('contents')
<header>
	@include('header')
</header>
<section>
	@include('logo')
	<div class="row">
		<div class="small-12 medium-7 large-7 columns small-centered">
			<div class="panel callout radius">
				<p class="tagline secondary-text">Settings</p>
				<table width="100%">
					<thead>
						<tr>
							<th width="60%" class="number-column">Key</th>
							<th width="40%" class="number-column">Value</th>
						</tr>
					</thead>
					<tbody>
						@foreach($settings as $setting)
							<tr>
								<td>{{ HTML::linkRoute('get.admin.settings.edit', $setting->setting_key, array($setting->id)) }}</td>
								<td class="number-column">{{ $setting->setting_value }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
@stop