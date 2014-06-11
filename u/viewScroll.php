<?php 
	include('../admin/mysql/connect.php');
	include_once('../admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}
 
			
	$fan_query = $db->prepare("SELECT * FROM fanScrolls WHERE link=:link");	
		
	$fan_arr = array(
			'link' => $_GET['image']
		);
		

	$x->arrayBinder($fan_query, $fan_arr);
		
	$fan_query->execute();
	$fanScroll = $fan_query->fetch(PDO::FETCH_ASSOC);		
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>FanArt - Scrolldier.com</title>
	<link rel="icon" type="image/png" href="<?php echo($main) ?>img/bunny.png">	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
</head>
<body>
	<?php include('../inc_/menu.php') ?>
	
	<div class="body" id="blog">
		<div class="container">
		
			<div class="span-3 div-center">	
			
				<img src="<?php echo($fanScroll['parma_link']) ?>" class="div-4" alt="" />

				<input type="text" readonly="" class="textbox div-4" name="" value="<?php echo($fanScroll['parma_link']) ?>" />
			</div>
			
		</div>
	</div>
<?php include("../inc_/footer.php"); ?>
</body>
</html>