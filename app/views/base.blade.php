<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>sitename.com</title>

	<!-- CSS files -->
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,500,300italic|Roboto+Slab:700,300,100">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/foundation.min.css">
	<link rel="stylesheet" href="css/main.css">

	<!-- script files -->
	<script src="js/vendor/modernizr.js"></script>
</head>
<body class="{{ $bodyClass }}">
	@yield('contents')
	@include('footer')
	<!-- script calls here -->
	<script src="js/vendor/jquery.js"></script>
	<script src="js/foundation.min.js"></script>
	<script src="js/typeahead.bundle.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>