@section('contents')
<header>
	@include('header')
</header>
<section>
	<!-- logo and tagline -->
	@include('home/home-logo')
	<!-- search bar -->
	@include('home/home-search')
	<!-- change location link/modal -->
	@include('home/home-location')
	<!-- other search options -->
	@include('home/home-browse')
</section>
@stop