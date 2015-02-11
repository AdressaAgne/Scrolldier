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
	<title>Scrolldier.com - Deck Search</title>
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
	<script src="<?php echo($main) ?>jquery.js"></script>
</head>
<body>

	<?php include('inc_/menu.php') ?>
		<div class="container">
			<div class="div-4">
				<h1>Advanced Deck Search</h1>
				
				<form method="post" action="">
				
					<label class="hand">
						<input type="checkbox" name="" value="" /> Contains Scroll
					</label>
					<br />
					<select>
						<option id="1">Gravelock Elder</option>
					</select>
				</form>
			</div>	
		</div>
		
	<?php include("inc_/footer.php"); ?>
</body>
</html>