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
 	
	// ressource
	// 0 = Decay
	// 1 = Energy
	// 2 = Growth
	// 3 = Order
	// 4 = Wild
	// 5 = Chaos		
	$extra = "";
	if ($_GET['r'] == 7) {
		$fan_query = $db->prepare("SELECT * FROM fanScrolls WHERE ressource = 0 ORDER BY id");
		
	} elseif ( isset($_GET['r']) && !empty($_GET['r']) ) {
		$fan_query = $db->prepare("SELECT * FROM fanScrolls WHERE ressource = :r ORDER BY id");
		$fan_arr = array(
					'r' => $_GET['r']
				);		
		$x->arrayBinder($fan_query, $fan_arr);
		
	} else {
		$fan_query = $db->prepare("SELECT * FROM fanScrolls ORDER BY id");
	}
	
		
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
			<div class="div-4">
				<?php if (isset($_SESSION['username'])) { ?>
						<a href="<?php echo($main)."scroll/designer" ?>" class="btn-modern btn-no-margin">New Scroll</a>
				<?php } ?>
				<div class="right">
					<a href="<?php echo($main."scroll/library/7/") ?>"><i class="icon-decay"></i></a>
					<a href="<?php echo($main."scroll/library/1/") ?>"><i class="icon-energy"></i></a>
					<a href="<?php echo($main."scroll/library/2/") ?>"><i class="icon-growth"></i></a>
					<a href="<?php echo($main."scroll/library/3/") ?>"><i class="icon-order"></i></a>
					<a href="<?php echo($main."scroll/library/4/") ?>"><i class="icon-wild"></i></a>
				</div>
			</div>
			<?php while ($fanScroll = $fan_query->fetch(PDO::FETCH_ASSOC)) { ?>
			<div class="span-2">
				<div class="div-4">	
				<p class=" align-center">Made by <a href="<?php echo($main."user/".$fanScroll['user']) ?>"><?php echo($fanScroll['user']) ?></a></p>
				
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