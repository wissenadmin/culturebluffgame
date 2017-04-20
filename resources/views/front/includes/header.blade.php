<!DOCTYPE html>
<!--[if lt IE 7]>   <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>     <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>     <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<!--[if IE]>
  <link rel="stylesheet"  href="css/ie8.css">
  <![endif]-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
    <meta name="format-detection" content="telephone=no">
    <title>:: Culture Buff Games ::</title>
    <link href="{{url('/resources/dashboard')}}/css/bootstrap.css" rel="stylesheet">
    <link href="{{url('/resources/dashboard')}}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{url('/resources/dashboard')}}/css/animate.css" rel="stylesheet">
    <link href="{{url('/resources/dashboard')}}/css/custom.css" rel="stylesheet">
    <link href="{{url('/resources/dashboard')}}/css/owl.carousel.css" rel="stylesheet">
    <link href="{{url()}}/resources/assets/front/css/animate.css" rel="stylesheet">
    <link href="{{url('/resources/dashboard')}}/css/main.css" rel="stylesheet">
    <script src="{{url('/resources/dashboard')}}/js/html5shiv.js"></script>
    <script src="{{url('/resources/dashboard')}}/js/html5shiv-printshiv.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="{{url()}}/resources/assets/front/js/wow.min.js" type="text/javascript"></script>
    <script src="{{url()}}/resources/assets/front/js/jquery.textillate.js" type="text/javascript"></script>
    <script src="{{url()}}/resources/assets/front/js/jquery.lettering.js" type="text/javascript"></script>
</head>

<body>
    <!--[if lt IE 9]>
    <script src="dist/html5shiv.js"></script>
    <![endif]-->
    <!--  <img class="home" src="images/00-homepage.jpg"> -->
<style type="text/css">
    .hiddenheader  {
        left: 0;
        position: absolute;
        top: 11px;
    }
</style>

<header>
	<div class="head-row1">
		<div class="container-fluid">
			<div class="top-characters">
				<a href="{{url()}}">
				<img class="img" src="{{url('resources/assets/front')}}/images/cartoon.png" width="147px"></a>
			</div>
			<div class="animate-character">
				<img  class="c-speak" src="{{url('resources/assets/front')}}/images/new-cartoon.png">
			</div>
			<div class="logo-top">
				<a href="{{url('home')}}">Culture Buff Games</a>
			</div>
		</div>
	</div>
	<div class="head-row2">
		<nav class="navbar">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
			 <ul class="nav navbar-nav">
				<li class="active"><a href="{{url()}}">Home</a></li>
				<li><a href="{{url('about')}}">About Us</a></li>
				<li><a href="{{url('faq')}}">FAQ's</a></li>
				<li><a href="{{url('contactus')}}">Contact Us</a></li>
			  </ul>
			</div>
			<!--/.nav-collapse -->
		</nav>
		@if(!empty(Auth::user()->user_id) &&Auth::user()->role_id == 1)
			<a href="{{url('admin')}}" class="login button">Admin Profile</a>
		@elseif(Request::segment(1) == 'front')
			<a href="{{url('frontlogout')}}" class="login button">Logout</a>
		@elseif(empty(Auth::user()->user_id))
			<a href="{{url('login')}}" class="login button">myCultureBuff</a>
		@else
			<a href="{{url('front/home')}}" class="login button">My Account</a>
		@endif


	</div>
</header>