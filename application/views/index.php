<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<head>
	<!--Start of Zendesk Chat Script-->
	<!-- <script type="text/javascript">
		window.$zopim || (function (d, s) {
			var z = $zopim = function (c) { z._.push(c) }, $ = z.s =
				d.createElement(s), e = d.getElementsByTagName(s)[0]; z.set = function (o) {
					z.set.
						_.push(o)
				}; z._ = []; z.set._ = []; $.async = !0; $.setAttribute("charset", "utf-8");
			$.src = "https://v2.zopim.com/?5yd0oPsWPUYIJKtcNw2bQTdgqmEPGPLx"; z.t = +new Date; $.
				type = "text/javascript"; e.parentNode.insertBefore($, e)
		})(document, "script");
	</script> -->
	<!--End of Zendesk Chat Script-->
	<meta fragment="" content="!" />
	<base href="http://localhost/jumping_souls/" />

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.transitions.css">
	<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Tangerine' rel='stylesheet' type='text/css'>
	<link href="Site/style/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link type="text/css" href="Site/style/animate.css" rel="stylesheet" />

	<link type="text/css" href="Site/style/default.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="Site/style/style.css">


	<script src="Site/js/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
	<script src="Site/js/bootstrap.min.js"></script>
	<script src="Site/js/app.js"></script>
	<script src="Site/js/routes.js"></script>
	<script src="Site/js/services.js"></script>
	<script src="Site/js/constants.js"></script>

	<script src="Site/js/jquery.easing.min.js"></script>
	<script src="Site/js/jquery.scrollTo.js"></script>
	<script src="Site/js/wow.min.js"></script>
	<!-- Custom Theme JavaScript -->
	<!-- <script src="Site/js/custom.js"></script> -->
	<script src="Site/js/contactform.js"></script>
	<title>Jumping Souls</title>
</head>

<body ng-app="mySiteApp">
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container" ng-controller="mySiteAppController">
			<div class="navbar-header page-scroll">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
					<i class="fa fa-bars"></i>
				</button>
				<a class="navbar-brand" ng-click="redirect();" href="#intro" >

				</a>
			</div>
			<div class="collapse navbar-collapse  navbar-main-collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a ng-click="redirect();" href="#intro">Home</a>
					</li>
					<li>
						<a ng-click="redirect();" href="#clienttestimonials">Testimonials</a>
					</li>
					<li>
						<a ng-click="redirect();" href="#contactus">Contact</a>
					</li>
					<li class="navlogo">
						<a ng-click="redirect();" href="#intro">
							<img class="navimg" id="logo-navbar-middle" src="Site/images/logo.png" alt="Logo Thing main logo">
						</a>
					</li>

					<li>
							<a href="Aboutus" id="whitetext">about</a>
						  </li>
						  <li class="dropdown">
							<a id="whitetext" href="#" class="dropdown-toggle" data-toggle="dropdown">Our Work
							  <b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
							  <li>
								<a href="Photos">Photo's</a>
							  </li>
							  <li>
								<a href="Videos">Video's</a>
							  </li>

				</ul>
				<li>
					  <a id="whitetext" href="Faq">FAQ's</a>
					</li>
					<li>
					  <a id="whitetext" href="Rental">Rental's</a>
					</li>
			</div>
		</div>
	</nav>
	<div ng-controller="mySiteAppController" ng-view="">
	</div>
	<footer class="site-footer">
 		<p class="site-info">&copy;Jumping Souls. All rights reserved.</p>
	</footer>
</body>
</html>
