<?php 
	include('admin/mysql/connect.php');
	include_once('admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}
	
	if (isset($_SESSION['username'])) {
		header('location: index.php');
	}
	
	if (isset($_POST['lign']) && isset($_POST['lpassword'])) {
		$login = $x->login($_POST['lign'], $_POST['lpassword']);
		if ($login === 1) {
			if (isset($_SESSION['lign'])) {
				if (isset($_GET['re']) && !empty($_GET['re'])) {
					header('location: '.$_GET['re']);
				} else {
					header('location: ../index.php');
				}
				
			}
		} else {
			$_GET['error'] = "Wrong login information";
			unset($_GET['success']);
		};
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolldier.com</title>
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>
	<div class="logo"></div>
	
	<div class="loginContainer modern clearfix">
		<h1>Login</h1>
		<form method="post" action="">
			<div class="div-1 div-margin">
				<label for="ign">In Game Name</label><br />
				<input type="text" class="textbox full div-2" name="lign" id="ign" value="" placeholder="In Game Name" />
			</div>
			<div class="div-1 div-margin">
				<label for="lpassword">Password</label><br />
				<input type="password" class="textbox full div-2" name="lpassword" id="lpassword" value="" placeholder="Password" />
			</div>
			<div class="div-1 div-margin">
				<input type="submit" name="" class="btn" value="Login" />
			</div>
		</form>
	</div>
<?php include("inc_/footer.php"); ?>
</body>
</html>