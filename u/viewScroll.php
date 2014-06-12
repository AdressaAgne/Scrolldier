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
	
	
	
	if (isset($_POST['delArt']) && $_SESSION['username'] == $fanScroll['user']) {
		
			$query = $db->prepare("DELETE FROM fanScrolls WHERE link=:link");	
				
			$Qarr = array(
					'link' => $_GET['image']
				);
				
		
			$x->arrayBinder($query, $Qarr);
				
			if ($query->execute()) {
				
				if (unlink("user_files/".strtolower($_SESSION['username'])."/".$fanScroll['link'].".png")) {
					header("location: ".$main."user");
				}
			}
		
	}
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
		<?php if (isset($_SESSION['username']) && $_SESSION['username'] == $fanScroll['user']) { ?>
		<div class="div-4">
			<form method="post" action="">
				<input type="submit" class="btn-modern btn-no-margin" name="delArt" value="Delete" />
			</form>
		</div>
		<?php } ?>
		
		<?php if ($fan_query->rowCount() != 0) { ?>
			<div class="span-3 div-center align-center">	
				<p><?php echo($fanScroll['title']) ?> is made by <?php echo($fanScroll['user']) ?></p>
				<img src="<?php echo($fanScroll['parma_link']) ?>" class="div-4" alt="" />
			</div>
			<div class="div-3 div-center">
				<input type="text" readonly="" class="textbox div-4" name="" value="<?php echo($fanScroll['parma_link']) ?>" />
			</div>
		<?php } else { ?>
			<div class="span-3 div-center align-center">	
			<p>Art does not exist anymore</p>
		</div>
		<?php } ?>	
		</div>
	</div>
<?php include("../inc_/footer.php"); ?>
</body>
</html>