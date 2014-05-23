<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
$x = new xClass();

session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}
if (!isset($_SESSION['username'])) {
	header("location: ".$main."login.php");
}
//preg_replace("/[^0-9]/","",'604-619-5135');
//FIX http://i.imgur.com/VHQ1OTR.jpg
	if (isset($_POST['deckSubmit']) && !empty($_POST['deckSubmit'])) {
		if (!empty($_POST['title'])) {
			if (!empty($_POST['link'])) {
				
				if (!empty($_POST['scrolls'])) {
					$scrolls = $_POST['scrolls'];
				} else {
					$scrolls = 50;
				}
					
					if (empty($_SESSION['username'])) {
						$_SESSION['username'] = $_POST['deck_author'];
					}
	
			
					if (isset($_POST['type_growth'])) {
						$growth = 1;
					} else {
						$growth = 0;
					}
					if (isset($_POST['type_order'])) {
						$order = 1;
					} else {
						$order = 0;
					}
					if (isset($_POST['type_energy'])) {
						$energy = 1;
					} else {
						$energy = 0;
					}
					if (isset($_POST['type_decay'])) {
						$decay = 1;
					} else {
						$decay = 0;
					}
					if (isset($_POST['type_wild'])) {
						$wild = 1;
					} else {
						$wild = 0;
					}
					
					if (isset($_POST['comp'])) {
						$comp = 1;
					} else {
						$comp = 0;
					}
					if (isset($_POST['isHidden'])) {
						$isHidden = 1;
					} else {
						$isHidden = 0;
					}
					
				//http://a.scrollsguide.com/deck/load?id=265 CHECK TO THIS LATER
					$query = $db->prepare("INSERT INTO decks (deck_title, deck_author, growth, energy, tOrder, decay, wild, meta, link, scrolls, text, competative, JSON, isHidden) VALUES(:deck_title, :deck_author, :growth, :energy, :order, :decay, :wild, :meta, :link, :scrolls, :text, :competative, :JSON, :isHidden)");
					
					$url = "http://a.scrollsguide.com/deck/load?id=".preg_replace("/[^0-9]/","", $_POST['link']);
					$JSON = file_get_contents($url);
					
					$arr = array(
							'deck_title' => $_POST['title'],
							'deck_author' => $_SESSION['username'],
							'growth' => $growth,
							'energy' => $energy,
							'order' => $order,
							'decay' => $decay,
							'wild' => $wild,
							'meta' => $_POST['meta'],
							'link' => preg_replace("/[^0-9]/","", $_POST['link']),
							'scrolls' => $scrolls,
							'text' => $_POST['description'],
							'competative' => $comp,
							'JSON' => $JSON,
							'isHidden' => $isHidden
							
						);
					
					$x->arrayBinder($query, $arr);
					
					if ($query->execute()) {
						$_GET['success'] = "Deck Submitted";
						header("location: ".$main."decks");
					}

				
				
			} else {
				$_GET['info'] = "Enter a Deck Link";
			}
			
		} else {
			$_GET['info'] = "Enter a Deck title";
		}
	}

//vars; title, scrolls, link, type_order, type_energy, type_growth, type_decay, type_wild, meta
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolls - New Deck</title>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="<?php echo($main) ?>jquery.js"></script>	 
	<script src="<?php echo($main) ?>plugins/ckeditor/ckeditor.js"></script>	
</head>
<body style="padding-bottom: 0px;">
	<?php include('inc_/menu.php'); ?>
	 
 	<div class="container">
 		<div class="div-3 div-margin">
 			<p>Don't post a deck that you found or have not made yourself. When you are posting it will show up in your name!</p>
 		</div>
 		<form method="post" class="div-marign" action="">
 			<div class="div-3 div-marign">
 				<label for="deck_title">Deck Title</label><br />
 				<input type="text" class="textbox full" name="title" id="deck_title" value="" />
 			</div>
 			
 			<div class="div-3 div-marign">
 				<label for="deck_scrolls">Total Scrolls in deck</label><br />
 				<input type="text" class="textbox full" name="scrolls" id="deck_scrolls" value="50" placeholder="50"/>
			</div>
			
			<div class="div-3 div-marign">
					<label for="deck_link"><a href="http://www.scrollsguide.com/deckbuilder">SG Deckbuilder deck link</a></label><br />
					<input type="text" class="textbox full" name="link" id="deck_link" value="" placeholder=""/>
			</div>
			
			<div class="div-3 div-marign">
					<label for="deck_scrolls">What type of deck is this?</label><br />
					<div class="chooseBox clearfix">
						<div class="checkbox">
							<ul class="">
							  <li>
							      <input id="order_checkbox2" type="checkbox" checked="checked" name="type_order" value="">
							      <label class="checkbox" for="order_checkbox2"><i class="icon-order"></i></label> 
							      
							  </li>
							  <li>  
							      <input id="energy_checkbox2" type="checkbox" name="type_energy" value="">
							      <label class="checkbox" for="energy_checkbox2"><i class="icon-energy"></i></label> 
							     
							  </li>
							  <li>
							      <input id="growth_checkbox2" type="checkbox" name="type_growth" value="">
							      <label class="checkbox" for="growth_checkbox2"><i class="icon-growth"></i></label> 
							  </li>
							 <li class="">
							     <input id="decay_checkbox2" type="checkbox" name="type_decay" value="">
							     <label class="checkbox" class="" for="decay_checkbox2"><i class="icon-decay"></i></label> 
							 </li>
							 <li class="">
							     <input id="wild_checkbox2" type="checkbox" name="type_wild" value="">
							     <label class="checkbox" class="" for="wild_checkbox2"><i class="icon-wild"></i></label> 
							 </li>
							</ul>
						</div>
					</div>
			</div>
			
			<div class="div-3 div-marign">
				<label>What meta is this deck designed for</label><br />
				<select name="meta">
					<option selected value="0.121.0">0.121.0 (Latest, Main Server)</option>
					<option value="0.119.1">0.119.1</option>
					<option value="0.117">0.117</option>
					<option value="0.112.2">0.112.2</option>
					<option value="0.110.5">0.110.5</option>
					<option value="0.105">0.105</option>
					<option value="0.103">0.103</option>
					<option value="0.97">0.97</option>
				</select>
 			</div>
 			<div class="div-3">
 				<input type="checkbox" name="comp" id="comp" value="1" />
 				<label for="comp">Is this a competitive deck? 1600+ Rating (Master Caller)</label>
 			</div>
 			<div class="div-3">
 				<input type="checkbox" name="isHidden" id="isHidden" value="1" />
 				<label for="isHidden">Make deck hidden, so only you can see it (Direct link still works for everyone)</label>
 			</div>
 			<div class="div-3">
 				<label for="desc">Write a summary of your deck, how do you play it?</label>
 				<textarea name="description" class="textarea" id="desc"></textarea>
 			</div>
 			<div class="div-3 div-marign">	
 				<input type="hidden" name="author" value="<?php echo($_SESSION['username']) ?>" />
 				<input type="hidden" name="deckSubmit" value="deckSubmit" />
 				<input type="submit" name="submit" class="btn" value="Post deck" />
 			</div>
 		</form>
 		
 	</div>
 <?php include("inc_/footer.php"); ?>
</body>
</html>