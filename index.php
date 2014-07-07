<?php 
	include('admin/mysql/connect.php');
	include('admin/mysql/deck.php');
	include_once('admin/mysql/function.php');
	$x = new xClass();
	
	$deckData = new deck();
	
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
			

		</div>
	
		<div class="container">
			
			<div class="wall_big">
				<!-- Blog -->
				<div class="div-4 modern" style="margin-top: 0px;">
					<h3>Spoilers & news</h3>
				</div>
				<?php
				//[LIMIT {[offset,] row_count | row_count OFFSET offset}]
				$query = $db->prepare("SELECT * FROM scrolls WHERE isHidden=0 ORDER BY time DESC LIMIT :limitStart, :limitEnd");
				
				$totalPosts = $db->prepare("SELECT * FROM scrolls WHERE isHidden=0");
				$totalPosts->execute();
				
				$totalPosts = $totalPosts->rowCount();
				
				$pageSize = 4;
				
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
				while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
						
				?>		
				
				<div class="last well div-4">
					<div class="header">
						<h1 style="margin-left: 10px;">
							<a href="post/<?php echo($row['id']) ?>">
								<?php echo($row['header']) ?>
							</a>
						</h1>
						
						
						
						<p class="byline">
							<?php echo($x->ago($row['time'])) ?> ago by
							 <a href="user/<?php echo($row['byName']) ?>"><?php echo($row['byName']) ?></a>
							 with <?php echo($x->totalComments($row['id'])) ?> comment(s)
							 
							 <small>
							 	<?php if (isset($_SESSION['username']) && ($_SESSION['rank'] == 1 || $_SESSION['username'] == $row['byName']))  { ?>
							 		<a class="btn-pagina modern right" href="edit.php?edit=<?php echo($row['id']) ?>">Edit</a>	
							 	<?php } ?>
							 </small>
						</p>
					</div>
					<div class="news_content">
						<?php echo($row['html']) ?>
					</div>
					<div class="readMore">
						<a href="post/<?php echo($row['id']) ?>" class="readMore fontDwarven"><h1>Continue Reading</h1></a>
					</div>
				</div>
				
				<?php } ?>
				<?php include("inc_/pagina.php"); ?>
			</div>
			
			<div class="wall_small">
			
				<a href="<?php echo($main) ?>new/deck" class="div-4 align-center btn-modern" style="margin-top: -1px;">
					<div class="header">
						<h1>Add a new deck!</h1>
					</div>
				</a>
			
			<h2 class="align-center modern div-4">Top 5 decks at the moment</h2>
			
			<div class="div-4">
				<?php 
					include("inc_/curve.php");
					$query = $db->prepare("SELECT * FROM decks WHERE isHidden = 0 AND competative = 1 AND vote > 2
										   ORDER BY meta DESC, vote DESC,
										   time DESC LIMIT 5");
					
					
					$query->execute();
					$i = 0;
					while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
					$i++;
					
					
						$dataArray = $deckData->getDeckDetails($row['id']);
						
						$deckType = $dataArray['faction'][0];
					
				 ?>
			
			
				<div class="div-4 classic clearfix <?php echo($deckType) ?>"  style="margin-bottom: 10px;">
				<a class="" href="<?php echo($main."deck/".$row['id']) ?>" >
					<div class="header clearfix">
					
						 <h2 class="left clear" style="font-size: 24px;">
						  	<?php echo($i.". ".substr($row['deck_title'],0 , 30)) ?>
					 	 </h2>
						
					 </div>
					  </a>
					<p class="left clear byline"><?php echo($x->ago($row['time'])) ?> ago by <?php echo($row['deck_author']) ?> with <?php echo($x->totalComments($row['id'], 2)) ?> comment(s) for <?php echo($row['meta']) ?></p>

					<div class="left clear classicDiv">
						<div class="left">
						<?php echo(addCurve($row['id'])); ?>
						</div>
						<span class="left">
							<?php if ($row['growth'] == 1) {
								echo('<i class="icon-growth big" style="margin-bottom: -3px;"></i>');
							}
							
							if ($row['decay'] == 1) {
								echo('<i class="icon-decay big" style="margin-bottom: -3px;"></i>');
							}
							
							if ($row['tOrder'] == 1) {
								echo('<i class="icon-order big" style="margin-bottom: -3px;"></i>');
							}
							
							if ($row['energy'] == 1) {
								echo('<i class="icon-energy big" style="margin-bottom: -3px;"></i>');
							}
							
							if ($row['wild'] == 1) {
								echo('<i class="icon-wild big" style="margin-bottom: -3px;"></i>');
							}
							 ?>
						</span>
						
						<span class="right white" style="margin-left: 10px;">
							<i class="icon-scrolls"></i> <span><?php echo($row['scrolls']) ?></span>
						</span>
						
						<span class="right white" style="margin-left: 10px;">
							<i class="icon-star"></i> <span><?php echo($row['vote']) ?></span>
						</span>
					</div>
					
					
					<div class="left clear classicDiv white align-center" style="font-size: 12px;">
						<?php if (!empty($dataArray['CREATURE'])) { ?>
							<span class=""><?php echo($dataArray['CREATURE']) ?> Creatures</span>
						<?php } ?>
						
						<?php if (!empty($dataArray['STRUCTURE'])) { ?>
							<span>- <?php echo($dataArray['STRUCTURE']) ?> Structurs</span>
						<?php } ?>
						
						<?php if (!empty($dataArray['SPELL'])) { ?>
							<span>- <?php echo($dataArray['SPELL']) ?> Spells</span>
						<?php } ?>
						
						<?php if (!empty($dataArray['ENCHANTMENT'])) { ?>
							<span>- <?php echo($dataArray['ENCHANTMENT']) ?> Enchantments</span>
						<?php } ?>
						
						
						<?php 
						$total_progress = $dataArray['CREATURE'] + $dataArray['STRUCTURE'] + $dataArray['SPELL'] + $dataArray['ENCHANTMENT'];
						
						$creatureProgess = $dataArray['CREATURE'] / $total_progress * 100;
						$structureProgess = $dataArray['STRUCTURE'] / $total_progress * 100;
						$spellProgess = $dataArray['SPELL'] / $total_progress * 100;
						$enchantProgess = $dataArray['ENCHANTMENT'] / $total_progress * 100;
						
						 ?>
					</div>
					
					<div class="progressbar">
						<div class="bar color-green" style="width: <?php echo($creatureProgess) ?>%;"></div>
						<div class="bar color-orange" style="width: <?php echo($structureProgess) ?>%;"></div>
						<div class="bar color-red" style="width: <?php echo($spellProgess) ?>%;"></div>
						<div class="bar color-blue" style="width: <?php echo($enchantProgess) ?>%;"></div>
					</div>
					
				</div>
				
				<?php } ?>
				
			</div>
			
			<h2 class="align-center modern div-4">Twitter Feed from devs</h2>
			<a class="twitter-timeline" href="https://twitter.com/Agne240/scrolls-devs" data-widget-id="453777615828963328">Tweets from https://twitter.com/Agne240/scrolls-devs</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			
				<?php if (($x->hasDonated($_SESSION['username']) == false && $_SESSION['rank'] == 4) || !isset($_SESSION['username'])) { ?>
				
					<?php include("inc_/ad/squere2.php"); ?>
				
				<?php } ?>
			
			</div>
			
			
			

			<div class="last">
				<?php if (($x->hasDonated($_SESSION['username']) == false && $_SESSION['rank'] == 4) || !isset($_SESSION['username'])) { ?>
				
					<?php include("inc_/ad/banner.php"); ?>
				
				<?php } ?>
			</div>
			
			
		</div>
	</div>
	<?php include("inc_/footer.php"); ?>
</body>
</html>