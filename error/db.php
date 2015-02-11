<?php $main = "http://$_SERVER[HTTP_HOST]/"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolldier.com</title>
	<link rel="icon" type="image/png" href="../img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/css/style.css" />

</head>
<body>	
	<div class="container">
		<div class="logo" onclick="location.href='<?php echo($main) ?>'"></div>
		<h1 class="align-center">We are having some troubles at the moment, please try again in a few minutes</h1>
		<p class="align-center">Some highly trained super Nogs are working on it</p>
			<p class="align-center"><a href="<?php echo($main) ?>">Try Again</a></p>
	</div>
</body>
</html>