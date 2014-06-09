<?php 
	include('admin/mysql/connect.php');
	include_once('admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}

	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Beetlestone Society Minecraft Server: </title>
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>

	<?php include('inc_/menu.php') ?>
		<div class="container">
				<h1>Beetlestone Society Minecraft Server <i class="icon-beetle"></i></h1>
				
				<div class="div-4 guild" style="padding: 20px;">
					<p>IP: BeetlestoneSociety.nn.pe:25568</p>
				</div>
				
				<div class="div-4">
				
				<a target="_blank" href="https://docs.google.com/spreadsheets/d/1X4vpIQuttIfIrzm2NUCbOTuQjn-D0NWeDwqd08GDDF4/edit#gid=0">Google Docs of members</a>
				</div>
				
				
			
		</div>
	<?php include("inc_/footer.php"); ?>
</body>
</html>