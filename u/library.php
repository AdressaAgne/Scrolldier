<?php 
	include('../admin/mysql/connect.php');
	include_once('../admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}
 
 	header('Cache-Control: no-cache');
 	header('Pragma: no-cache');
 	
			
	$fan_query = $db->prepare("SELECT * FROM fanScrolls ORDER BY id");	
	$fan_query->execute();

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
			<?php if (isset($_SESSION['username'])) { ?>
				<div class="div-4">
					<a href="<?php echo($main)."scroll/designer" ?>" class="btn-modern btn-no-margin">New Scroll</a>
				</div>
			<?php } ?>
			<?php while ($fanScroll = $fan_query->fetch(PDO::FETCH_ASSOC)) { ?>
			<div class="span-2">
				<div class="div-4">	
				<p>by <?php echo($fanScroll['user']) ?></p>
				
				<a href="<?php echo($main."fanart/".$fanScroll['link']) ?>">
					<img src="<?php echo($fanScroll['parma_link']) ?>" class="div-4" alt="" />
				</a>
				</div>
			</div>
		<?php } ?>	
		</div>
	</div>
<?php include("../inc_/footer.php"); ?>
</body>
</html>