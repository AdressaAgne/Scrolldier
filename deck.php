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
</head>
<body>

	<?php include('inc_/menu.php') ?>
	<?php 
		
		if (!isset($_GET['orderBy'])) {$_GET['orderBy'] = ""; }
		
		if ($_GET['orderBy'] == "name") {
			$query = $db->prepare("SELECT * FROM decks ORDER BY deck_title ASC, time DESC");
		} elseif ($_GET['orderBy'] == "author") {
			$query = $db->prepare("SELECT * FROM decks ORDER BY deck_author ASC, time DESC");
		} elseif ($_GET['orderBy'] == "scrolls") {
			$query = $db->prepare("SELECT * FROM decks ORDER BY scrolls DESC, time DESC");
		} elseif ($_GET['orderBy'] == "vote") {
			$query = $db->prepare("SELECT * FROM decks ORDER BY vote DESC, time DESC");
		} elseif ($_GET['orderBy'] == "type") {
			$query = $db->prepare("SELECT * FROM decks ORDER BY growth, decay, tOrder, energy, wild  DESC, time DESC");
		} else {
			$query = $db->prepare("SELECT * FROM decks ORDER BY meta DESC, vote DESC, time DESC");
		}
		
		
		$query->execute();
	 ?>
		<div class="container">
			
				
			
			<div class="decks div-margin">
			
			<?php if (isset($_SESSION['username'])) { ?>
				<div class="left" style="margin-left: -5px; margin-bottom: 10px; margin-top: 0px;">
					<a class="btn-modern" href="../new_deck.php">New Deck</a><br />
				</div>
				<!--<div class=""  style="margin-left: -5px; margin-bottom: 10px; margin-top: 0px;">
					<form method="post" action="" class="right">
						<input type="search" name="" class="search" value="" placeholder="search..."/>
					</form>
				</div>-->
			<?php } ?>
			
				<table>
					<tr class="modern">
						<td><a href="?orderBy=vote">Score</a></td>
						<td width="300px"><a href="?orderBy=name">Name</a></td>
						
						<td>Curve</td>
						<td width="120px"><a href="?orderBy=type">Type</a></td>
						<td width="50px"><a href="?orderBy=scrolls">Scrolls</a></td>
<!--						<td>time</td>-->
						<td>Version</td>
						<td width=""><a href="?orderBy=author">Author</a></td>	
						<td>Comments</td>
					</tr>
					<?php include("inc_/curve.php"); ?>
					<?php while ($deck = $query->fetch(PDO::FETCH_ASSOC)) { ?>
					
					<tr>
						<td class="align-center"><?php echo($deck['vote']) ?></td>
						<td><a href="http://www.scrollsguide.com/deckbuilder/#<?php echo($deck['link']) ?>" target="_blank"><?php echo($deck['deck_title']) ?></a></td>
						<td>
						
							<?php echo(addCurve($deck['id'])); ?>
						</td>
						<td>
							<?php if ($deck['growth'] == 1) {
								echo('<i class="icon-growth"></i>');
							}
							
							if ($deck['decay'] == 1) {
								echo('<i class="icon-decay"></i>');
							}
							
							if ($deck['tOrder'] == 1) {
								echo('<i class="icon-order"></i>');
							}
							
							if ($deck['energy'] == 1) {
								echo('<i class="icon-energy"></i>');
							}
							
							if ($deck['wild'] == 1) {
								echo('<i class="icon-wild"></i>');
							}
							 ?>
						</td>
						<td><?php echo($deck['scrolls']) ?></td>
<!--						<td><?php echo($deck['time']) ?></td>-->
						<td><?php echo($deck['meta']) ?></td>
						<td><a href="u/?u=<?php echo($deck['deck_author']) ?>"><?php echo($deck['deck_author']) ?></a></td>	
						<td><a href="deck_comment.php?d=<?php echo($deck['id']) ?>">more... (<?php echo($x->totalComments($deck['id'], 2)) ?>)</a></td>
						
					</tr>
					
					<?php } ?>
				</table>
								
			</div>
			
		</div>
	<?php include("inc_/footer.php"); ?>
</body>
</html>