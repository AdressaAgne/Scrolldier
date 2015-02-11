<?php 

	//databases
	session_start();
	
	include('../admin/mysql/connect.php');
	include_once('../admin/mysql/function.php');
	$x = new xClass();


	require_once("controllers/pdo.php");
	require_once("controllers/deckController.php");
	$deck = new Deck();

	
	
//	if (isset($_GET['logout'])) {
//		$x->logout();
//	}
	
	if (!isset($_SESSION['username'])) {
		header("location: http://scrolldier.com/login.php?re=competition/");
	}

	
//	if (isset($_POST['submit'])) {
//		$data = $deck->get_deck_data($_POST['deck_id']);
//		if ($x->hasSubmitted($_POST['deck_cat'], $_SESSION['username'])) {
//		
//			if (!empty($_POST['deck_title'])) {
//				if ($data->scroll_count == 50) {
//					
//					if ($data->rarities[2] <= 8) {
//						
//						if ($data->rarities[1] <= 18) {
//							
//							if ($data->set[6] >= 20) {
//							
//								$SC = $data->kinds['CREATURE'] + $data->kinds['STRUCTURE'];
//								if ($SC >= 20) {
//									
//									
//									if (($data->resources[$_POST['deck_cat']] == 50) || ($data->resources['order'] >= 10 && $data->resources['energy'] >= 10 && $_POST['deck_cat'] == "order/energy") || ($data->resources['growth'] >= 10 && $data->resources['decay'] >= 10 && $_POST['deck_cat'] == "decay/growth")) {
//										
//									
//									
//									$query = $db->prepare("INSERT INTO competition (deck_title, deck_author, deck_desc, deck_category, deck_id) VALUES(:title, :author, :desc,:cat, :id)");
//									$arr = array(
//											'title' => $_POST['deck_title'],
//											'desc' => $_POST['deck_desc'],
//											'author' => $_POST['deck_author'],
//											'cat' =>  $_POST['deck_cat'],
//											'id' => $_POST['deck_id']
//										);
//									
//									$x->arrayBinder($query, $arr);
//									
//									if ($query->execute()) {
//										$_GET['success'] = "Your deck ".$_POST['deck_title']." was submitted to the ".$_POST['deck_cat']." category"; 
//									}
//									} else {
//										$_GET['error'] = "Your deck does not match the submission category. (".$_POST['deck_cat'].")";
//									}
//								} else {
//									$_GET['error'] = "Your deck must contain at least 20 units. (Yours has: ".$SC.")";
//								}
//								
//								
//							} else {
//								$_GET['error'] = "Your deck must have at least 20 scrolls from the latest set. (Waypoints) (Yours has: ".$data->set[6].")";
//							}
//							
//							
//						} else {
//							$_GET['error'] = "You cannot have more than 18 Uncommon scrolls in a deck. (Yours has: ".$data->rarities[1].")";
//						}
//						
//						
//					} else {
//						$_GET['error'] = "You cannot have more than 8 Rare scrolls in a deck. (Yours has: ".$data->rarities[2].")";
//					}
//					
//					
//				} else {
//					$_GET['error'] = "Your deck must contain 50 Scrolls exactly. (Yours has: ".$data->scroll_count.")";
//				}
//			} else {
//				$_GET['error'] = "Your deck must have a name.";
//			}
//			
//		} else {
//			$_GET['error'] = "You have already posted to this category.";
//		}	
//	}
	

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
	<title>Official Scrolls Pre-Constructed Deck Competition - Submit</title>
	
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

	<?php if (isset($_GET['success'])) { ?>
	<div class="container dialog" id="successcontainer">
		<div class="row">
			<div class="col-12 tag success">
				<div class="left"><p id="successMessage"><?=$_GET['success']?></p></div>
				<div class="close"><p id="successCloseBtn">&times;</p></div>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if (isset($_GET['error'])) { ?>
	<div class="container dialog" id="errorcontainer">
		<div class="row ">
			<div class="col-12 tag error">
				<div class="left"><p id="errorMessage"><?=$_GET['error']?></p></div>
				<div class="close"><p id="errorCloseBtn">&times;</p></div>
			</div>
		</div>
	</div>
	<?php } ?>
		
		
			<div class="container">
				<div class="align-center">
					<img src="mojang_logo_new1.png" width="400px" alt="" /><br />
					<img src="http://scrolldier.com/img/Scrolldier_new.png" width="200px" alt="" />
				</div>
				
				<div class="page-header align-center">
					<h1>Official Scrolls Pre-Constructed Deck Competition</h1>
				</div>
				<h3 class="align-center" style="margin-bottom: 20px;">Here is your chance to get a deck YOU have designed into the game.</h3>
				<div class="row news">
					<div class="col-10 col-offset-1 col-tab-10 col-tab-offset-1 col-phone-12">
					<h3>Good day Scrolldiers!</h3>
					
					<p>The Waypoints expansion was all about the different vistas and places of the world of Scrolls, from the towering peaks of the Aescelon Spires to the ominous Forbidden Ruins, in the form of Lingering spells, but you may have noticed that with the expansion came no associated preconstructed decks like with the Rebellion expansion.</p>
					
					<p>Do not fret - you’re going to design some!</p>
					
					<p>That’s right, for the first time ever, the community will be able to submit Waypoints preconstructed decks that have a chance to end up sold in the Store. We’re looking for six decks in total to put up in the Store, one for each category:</p>
					
					<ul>
						<li><i class="icon-decay"></i> Decay</li>
						<li><i class="icon-growth"></i> Growth</li>
						<li><i class="icon-energy"></i> Energy</li>
						<li><i class="icon-order"></i> Order</li>
						<li><i class="icon-decay"></i><i class="icon-growth"></i> Decay/Growth</li>
						<li><i class="icon-order"></i><i class="icon-energy"></i> Order/Energy</li>
					</ul>
					<p>So open that deck builder, put together old and new scrolls to craft decks that you think will be both fun and balanced, but most importantly - that encapsulates what Waypoints is all about.  You’ll want to pick a Waypoint appropriate deck name and deck description, so take a look at the way the Rebellion preconstructed decks are written for inspiration here.</p>
					
					<p>Please note that the winning decks, their names, and deck descriptions may be further tweaked by Mojang and its partners.</p>
					
					<h3>Prize</h3>
					
					<p>Six winners, one for each category, will receive the deck that ends up being implemented in the Store for the category they made their entry for. They will also be awarded the design competition avatar head.</p>
					<div class="image">
						<img src="head.png" alt="Scrolls Design Competition Head" width="150px" />
					</div>
					<h3>Deadline</h3>
					
					<p>All entries must be submitted by 11pm GMT the 6th of January, 2015. </p>
					
					
					<div class="page-header">
						<h3>Rules</h3>
					</div>
						<ul>
							<li>You may submit decks to all six categories, but only 1 per category.</li>
							<li>The submitted deck size must be 50 scrolls.</li>
							<li>Submissions must contain at least 20 scrolls from the latest set (Waypoints, Set #6)</li>
							<li>You may not include more than 8 total Rare scrolls and  18 total Uncommon scrolls.</li>
							<li>Submissions may not have more than 2 copies of Rare and Uncommon scrolls.</li>
							<li>Submissions must contain at least 20 creatures or structures.</li>
							<li>Only decks containing Decay scrolls may be submitted to the Decay category</li>
							<li>Only decks containing Growth scrolls may be submitted to the Growth category</li>
							<li>Only decks containing Energy scrolls may be submitted to the Energy category</li>
							<li>Only decks containing Order scrolls may be submitted to the Order category</li>
							<li>Only decks containing Decay and Growth scrolls may be submitted to the Decay/Growth category</li>
							<li>Only decks containing Order and Energy scrolls may be submitted to the Order/Energy category</li>
						</ul>
					<div class="page-header">
						<h3>Judging</h3>
					</div>
					<p>Judging will be done by Mojang and a number of people from the Scrolls community. The Judges will look at the highest voted decks and choose a winner for each category.</p>
					</div>
				</div>
				
				<div class="col-10 col-offset-1 col-tab-10 col-tab-offset-1 col-phone-12">
				<div class="row">
					<p>Build your deck <a href="http://scrolldier.com/new/deck" target="_blank">here</a> first, then submit it using the form below </p>
					<div class="form-element align-center">
						<h1>Competition is Over <br /><small>you can still view all decks and vote on them</small></h1>
					</div>
					
					<div class="form-element align-center">
						<h3><a href="submitted.php">View Submitted Decks</a></h3>
					</div>
					
					<!--<form method="post" action="">
						<div class="row">
							<div class="col-6 col-phone-12">
								<div class="form-element">
									<label for="deck_name">Deck Name <small style="color: #CE0000;">*</small><br /><small>Example: “Rise of Urhald”</small></label>
									<input type="text" id="deck_name" name="deck_title" value="<?php if (isset($_POST['deck_title'])) {
										echo($_POST['deck_title']);
									} ?>" placeholder="Deck Name" />
								</div>
							</div>
							
							<div class="col-6 col-phone-12">
								<div class="form-element">
									<label for="deck_ign">In-Game Name <small style="color: #CE0000;">*</small><br /><small>Example: <?=$_SESSION['username']?></small></label>
									<input type="text" id="deck_ign" name="deck_author" value="<?=$_SESSION['username']?>" placeholder="In-Game Name" />
								</div>
							</div>
						</div>
						<div class="row">
						
							<div class="col-6 col-tab-12">
								<div class="form-element">
									<label for="deck_id">Select Your deck <small style="color: #CE0000;">*</small><br /> <small>From your Scrolldier library</small></label>
									<select id="deck_id" name="deck_id">
										<?php 
											$query = $db->prepare("SELECT * FROM decks WHERE deck_author = :ign
																   ORDER BY isHidden DESC,
																   meta DESC, vote DESC,
																   time DESC");
											
											$arr = array(
													'ign' => $_SESSION['username']
												);
											$x->arrayBinder($query, $arr);
											
											
											$query->execute();
											
											while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
											
											
											<option value="<?=$row['id']?>"><?=$row['deck_title']?></option>
											
										<?php } ?>
										</select>
								</div>
								<div class="form-element">
								
								</div>
							</div>
							
							<div class="col-6 col-tab-12">
								<div class="form-element">
									<label for="deck_cat">Category <small style="color: #CE0000;">*</small><br /><small>You can only submit 1 deck to each category</small></label>
									<select id="deck_cat" name="deck_cat">
										<option value="decay">Decay</option>
										<option value="growth">Growth</option>
										<option value="energy">Energy</option>
										<option value="order">Order</option>
										<option value="decay/growth">Decay & Growth</option>
										<option value="order/energy">Order & Energy</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-element">
									<label for="deck_desc">Deck Description <small>Optional</small><br /><small>Example: “50 Growth scrolls. A great way to boost your collection!
									Guide Jarl Urhald's forces to victory and lead the rebellion against the mighty Empire. With the mystical Earthborn as your ally, create powerhouse units to take down your foes.
									Rise of Urhald is an aggressive deck with a focus on powerful enchantments. Special units and spells synergise with the enchantments to make your units hit fast and hard.”</small></label>
									<div class="textarea">
										<textarea id="deck_desc" name="deck_desc" rows="5" placeholder="Description of your deck"><?php if (isset($_POST['deck_desc'])) {
											echo($_POST['deck_desc']);
										} ?></textarea>
									</div>
								</div>
							</div>
						</div>
						
						
						<div class="row">
							<div class="col-12">
								<div class="form-element align-center">
									<button type="submit" name="submit" class="btn big">Submit Deck</button>
								</div>
								
								<div class="form-element align-center">
									<h3><a href="submitted.php">View Submitted Decks</a></h3>
								</div>
							</div>
						</div>
					</form>-->
				</div>
				</div>
				<div style="margin-top: 40px;" class="row">
					<div class="col-12" style="padding: 50px;"></div>
				</div>
			</div>	
			<script>
				$(function() {
					$("#successCloseBtn").click(function() {
							$("#successcontainer").hide();
						});
						
					$("#errorCloseBtn").click(function() {
							$("#errorcontainer").hide();
						});
				});
			</script>
	</body>
</html>