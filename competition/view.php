<?php 
//error_reporting(-1);
//ini_set('display_errors', 'On');
	//databases
	
	
	include('../admin/mysql/connect.php');
	include_once('../admin/mysql/function.php');
	$x = new xClass();
	
	require_once("controllers/pdo.php");
	require_once("controllers/deckController.php");
	
	session_start();
	$deck = new Deck();
	

	if (isset($_GET['logout'])) {
		$x->logout();
	}

		
	$query = $db->prepare("SELECT * FROM competition WHERE id = :id ORDER BY deck_time DESC");
	$arr = array(
			'id' => $_GET['deck']
		);
	$x->arrayBinder($query, $arr);
	
	if ($query->execute()) {
		$row = $query->fetch(PDO::FETCH_ASSOC);
		
		if ($query->rowCount() != 1) {
			header("location: submitted.php");
		}
		
	} else {
		echo("error");
	}
	
	

	if (isset($_POST['VoteUp']) && !empty($_POST['VoteUp'])) {
		$x->deckVoteComp($row['id'], $_SESSION['username']);
	}
	
	if (($_SESSION['username'] == $row['deck_author'] || $_SESSION['rank'] == 1 || $_SESSION['rank'] == 5) && isset($_POST['delete'])) {
		$x->delPostComp($row['id']);
		header("location: submitted.php");
	}
	
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Agne Ødegaard" />
	<meta name="description" content="" />
	<meta name="application-name" content="Scrolldier" />
	
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Apple Device: App-->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	
	<!-- Apple Device: Remove Status bar-->
	<meta name="apple-mobile-web-app-status-bar-style" content=“black”>
	
	<!--	Getting page title-->
	<title>Official Scrolls Pre-Constructed Deck Competition - <?= $row['deck_title'] ?></title>
	
	<!--Main css-->
	<link rel="stylesheet" href="css/style.css" />


	
	
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!--jQuery-1.11.1.min-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-49724500-1', 'scrolldier.com');
	  ga('send', 'pageview');
	
	</script>

</head>
	<body>
<style>

.deck-head-container{
	padding-bottom: 0px;
	padding-top: 100px;
	height: 555px;
}
</style>
<!--style="background-image: url(/img/decks/);"-->

	<div class="align-center">
		<img src="mojang_logo_new1.png" width="400px" alt="" /><br />
		<img src="http://scrolldier.com/img/Scrolldier_new.png" width="200px" alt="" />
	</div>
	<div class="container">
		
		<div class="deck-head clearfix">
				<div class="col-12">
					<div class="page-header" style="margin-top: -11px;">
						<h2><?=$row['deck_title']?> <small>Votes: <?= $row['deck_vote'] ?>, Category: <?=$row['deck_category']?><?php if ($_SESSION['rank'] == 1 || $_SESSION['rank'] == 5) {
							echo(", by: ".$row['deck_author']);
						} ?></small>
						<br /><small><a href="submitted.php">back</a></small>
						<?php if ($row['deck_author'] == $_SESSION['username'] || $_SESSION['rank'] == 1 || $_SESSION['rank'] == 5) { ?>
							<div class="right">
								<form method="post" action="">
									<button type="submit" name="delete" class="btn danger">Delete Submisssion</button>
								</form>
							</div>
						<?php } ?>
						</h2>
						
					</div>
					
			</div>
			
			
			<?php $data = $deck->get_deck_data($row['deck_id']); ?>
			<div class="col-6 col-offset-3 align-center">
			<?php if ($x->hasVotedComp($_SESSION['username'], $row['id']) && isset($_SESSION['username'])) { ?>
			
				<form method="post" action="" class="col-12">
					<input type="hidden" name="VoteUp" value="VoteUp" />
					<button type="submit" class="btn big success" id="vote_up"><i class="fa fa-thumbs-up"></i> Vote Up</button>
				</form>
			<?php } ?>
			</div>
			<div class="row">
				<div class="row">
					<div class="col-12 deck-scrolls">
						<?php foreach ($data->scrolls as $scroll) { ?>
							<div class="col-2 col-phone-6 col-tab-3" data-id="<?=$scroll->id ?>" data-count="<?=$scroll->count ?>">
								<div class="col-12 scroll scroll-stack-<?=$scroll->count ?>" style="background-image: url('http://dev.scrolldier.com/img/scrolls/<?=$scroll->image ?>.png');">
									<i class="icon-<?=$scroll->faction ?>"></i>
								</div>
								<div class="col-12 scroll-content">
									x<?=$scroll->count ?> <?=$scroll->name ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-12 col-tab-12">
						
					<div class="page-header">
						<h3><i class="fa fa-bar-chart"></i> Statistics <small>General</small></h3>
					</div>	
		
					<div class="col-4">
					
						<div class="col-12">
							<h4 class="list-stats">Types</h4>
							<div class="col-12">
								<ul class="list-stats">
									<?php foreach ($data->kinds as $kind => $count) {
										echo "<li><span><i class='ball-$kind'></i>".ucfirst(strtolower($kind)).":</span> <span class='right'>$count</span></li>";
									} ?>
		
								</ul>
							</div>
						</div>
						
						<div class="col-12">
							<h4 class="list-stats">Sets</h4>
							<div class="col-12">
								<ul class="list-stats">
									<?php foreach ($data->set as $sets => $count) {
										echo "<li><span>".$sets.":</span> <span class='right'>$count</span></li>";
									} ?>
		
								</ul>
							</div>
						</div>
					
		
						<div class="col-12">
							<h4 class="list-stats">Rarities</h4>
							<ul class="list-stats">
								<?php foreach ($data->rarities as $rarity => $count) {
		
									switch ($rarity) {
										case 0:
											echo "<li><span>Common:</span> <span class='right'>$count</span></li>";
										break;
		
										case 1:
											echo "<li><span>Uncommon:</span> <span class='right'>$count</span></li>";
										break;
		
										case 2:
											echo "<li><span>Rare:</span> <span class='right'>$count</span></li>";
										break;
									}
		
							
								} ?>
							</ul>
						</div>
					</div>
					<div class="col-8">
						<?= $row['deck_desc'] ?>
					</div>
				</div>
				</div>
				<?php if ($_SESSION['rank'] == 1 || $_SESSION['rank'] == 5) { ?>
				<div class="row">
					<div class="col-12">
						<div class="form-element">
						<textarea rows="6" disabled><?= $data->export ?></textarea>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<div style="margin-top: 40px;" class="row">
			<div class="col-12" style="padding: 50px;"></div>
		</div>
	</div>
	
</body>
</html>