<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<title>Title</title>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
	<link href="http://fonts.googleapis.com/css?family=Kreon" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="/css/style.css" />
	<script src="/js/jquery-1.6.2.js" type="text/javascript"></script>
</head>
<body>
<div id="wrapper">
	<header>
		<div id="header">
			<div id="logo">
				<a href="/"></span> <span class="cms">NAME</span></a>
			</div>
			<div id="menu">
				<ul>
					<li class="first active"><a href="/">Main page</a></li>
					<li><a href="/auth/login">Login</a></li>
					<li><a href="/auth/registration">Registration</a></li>
					<li class="last"><a href="/auth/logout">Exit</a></li>
				</ul>
				<br class="clearfix" />
			</div>
		</div>
	</header>
	<div id="page">
		<div id="content">
			<div class="box">
				<?php include 'source/views/'.$contentView; ?>
			</div>
			<br class="clearfix" />
		</div>
		<br class="clearfix" />
	</div>
</div>
<div id="footer">
	<a href="/">FOOTER</a> &copy; 2018</a>
</div>
</body>
</html>