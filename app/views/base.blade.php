<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>carfetch.com</title>

	<!-- favicon files -->
    <link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="favicon-194x194.png" sizes="194x194">
    <link rel="icon" type="image/png" href="android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="manifest.json">
    <meta name="msapplication-TileColor" content="#3498db">
    <meta name="msapplication-TileImage" content="mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">

	<!-- CSS files -->
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,500,300italic|Roboto+Slab:700,300,100">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ URL::asset('css/normalize.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/pikaday.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/foundation.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/main.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}">
</head>
<body class="{{ $body_class }}">
	@yield('contents')
	@include('footer')
	<!-- script calls here -->
	<script src="{{ URL::asset('js/vendor/modernizr.js') }}"></script>
	<script src="{{ URL::asset('js/vendor/jquery.js') }}"></script>
	<script src="{{ URL::asset('js/vendor/fastclick.js') }}"></script>
	<script src="{{ URL::asset('js/foundation.min.js') }}"></script>
	<script src="{{ URL::asset('js/typeahead.bundle.min.js') }}"></script>
	<script src="{{ URL::asset('js/jquery.simplePagination.js') }}"></script>
	<script src="{{ URL::asset('js/jquery.touchSwipe.min.js') }}"></script>
	<script src="{{ URL::asset('js/moment.min.js') }}"></script>
	<script src="{{ URL::asset('js/pikaday.js') }}"></script>
	<script src="{{ URL::asset('js/main.js') }}"></script>
	<script src="{{ URL::asset('js/application.js') }}"></script>

	<script> (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-60131582-1', 'auto'); ga('send', 'pageview');
	</script>​
</body>
</html>