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
	<title>Scrolldier.com</title>
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" />
	<?php include("inc_/ad/main.php"); ?>
</head>
<body>

	<?php include('inc_/menu.php') ?>
	
	
	<div class="body" id="blog">
		<div class="container">
			
				<?php include("inc_/liveStreams.php") ?>
		</div>
	
		<div class="container">
			
			<div class="news">
				<!-- Blog -->
				
				<?php
				//[LIMIT {[offset,] row_count | row_count OFFSET offset}]
				$query = $db->prepare("SELECT * FROM scrolls WHERE isHidden=0 ORDER BY time DESC LIMIT :limitStart, :limitEnd");	
				
				$pageSize = 5;
				
				if (!isset($_GET['p']) || empty($_GET['p'])) {
					$page = 1;
				} else {
					$page = intval($_GET['p']);
				}
				
				$stop = $pageSize;
				
				$start = ($page-1) * $pageSize;
				
				if ($start < 0) {
					$start = 0;
				}
				
				$arr = array(
						'limitStart' => $start,
						'limitEnd' => $stop,
					);
				$x->arrayBinderInt($query, $arr);	
				
					
				$query->execute();
				include("inc_/pagina.php");
				while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
						
				?>		
				
				<div class="last">
					<div class="header">
						<h3><a href="post/<?php echo($row['id']) ?>"><?php echo($row['header']) ?></a><small><?php if (isset($_SESSION['username']) && ($_SESSION['rank'] == 1 || $_SESSION['username'] == $row['byName']))  { ?>
								<a class="btn-pagina modern right" href="edit.php?edit=<?php echo($row['id']) ?>">Edit</a>	
						<?php } ?></small></h3>
						<small><?php echo($x->ago($row['time'])) ?>, By: <a href="user/<?php echo($row['byName']) ?>"><?php echo($row['byName']) ?></a>, (comments: <?php echo($x->totalComments($row['id'])) ?>)</small>
					</div>
					<div class="news_content">
						<?php echo($row['html']) ?>
					</div>
					<div class="readMore">
						<a href="post/<?php echo($row['id']) ?>" class="readMore">Continue Reading</a>
					</div>
				</div>
				
				<?php } ?>
				
				<?php include("inc_/pagina.php"); ?>
			</div>
			
			<div class="news_wall" style="height: 1000px;">
				<h2>Twitter Feed from devs</h2>
			<a class="twitter-timeline" href="https://twitter.com/Agne240/scrolls-devs" data-widget-id="453777615828963328">Tweets from https://twitter.com/Agne240/scrolls-devs</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			
			</div>
			
			
			
			
			
			<?php if (($x->hasDonated($_SESSION['username']) == false && $_SESSION['rank'] == 4) || !isset($_SESSION['username'])) { ?>
			
			<div class="news_wall">
				<?php include("inc_/ad/squere2.php"); ?>
			</div>
			<div class="last">
				<?php include("inc_/ad/banner.php"); ?>
			</div>
			
			<?php } ?>
		</div>
	</div>
	<?php include("inc_/footer.php"); ?>
</body>
</html>