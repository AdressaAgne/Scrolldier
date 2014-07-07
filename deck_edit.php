<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
$x = new xClass();
session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}

$query = $db->prepare("SELECT * FROM decks WHERE id=:id");
$arr = array(
		'id' => $_GET['d']
	);



$x->arrayBinder($query, $arr);
$query->execute();		
$row = $query->fetch(PDO::FETCH_ASSOC);

if ($row['deck_author'] != $_SESSION['username']) {
	header("location: http://scrolldier.com/decks");
}

if (isset($_POST['submit']) && $_SESSION['username'] == $row['deck_author']) {

	$query = $db->prepare("UPDATE decks SET text=:html, deck_title=:deck_title, isHidden=:isHidden, meta=:meta WHERE id=:id");
	if (isset($_POST['isHidden'])) {
		$isHidden = 1;
	} else {
		$isHidden = 0;
	}
	$arr = array(
			'html' => $_POST['html'],
			'isHidden' => $isHidden,
			'deck_title' => $_POST['deck_title'],
			'meta' => $_POST['meta'],
			'id' => $_GET['d']
		); 
	
	$x->arrayBinder($query, $arr);
	
	if ($query->execute()) {
		header("location:".$main."deck/".$_GET['d']);
	}

} 

if (isset($_POST['postID']) && !empty($_POST['postID'])) {
	$x->delComment($_POST['postID']);
}

if (isset($_POST['warningUser']) && !empty($_POST['warningUser'])) {
	$x->warnUser($_POST['warningUser']);
	$x->warnPost($_POST['warningPost']);
	
}

if (isset($_POST['VoteUp']) && !empty($_POST['VoteUp'])) {
	$x->deckVote($_POST['deckID'], true, $_SESSION['username']);
}
if (isset($_POST['VoteDown']) && !empty($_POST['VoteDown'])) {
	$x->deckVote($_POST['deckID'], false, $_SESSION['username']);
}

if (!isset($_GET['s']) || empty($_GET['s'])) {
	$_GET['s'] = 1;
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo($row['deck_title']) ?> - Deck - Scrolldier.com</title>
	<link rel="icon" type="image/png" href="<?php echo($main) ?>img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
	<link href="<?php echo($main) ?>plugins/lightbox/css/lightbox.css" rel="stylesheet" />
	<script src="<?php echo($main) ?>plugins/lightbox/js/jquery-1.11.0.min.js"></script>
	<script src="<?php echo($main) ?>plugins/lightbox/js/lightbox.min.js"></script>	 
	<script src="<?php echo($main) ?>plugins/ckeditor/ckeditor.js"></script>
</head>
<body>
	<?php include('inc_/menu.php') ?>
	<div class="body" id="blog">
		<div class="container">
			<!--Top title-->
			<div class="container clearfix">
					<div class="left">
						<i class="icon-deck"></i>	
					</div>
					
					<div class="left">
						<h1><a href="http://www.scrollsguide.com/deckbuilder/#<?php echo($row['link']) ?>" target="_blank"><?php echo($row['deck_title']) ?></a></h1>
						
						<small><?php echo($x->ago($row['time'])) ?> by <a href="user/<?php echo($row['deck_author']) ?>"><?php echo($row['deck_author']) ?></a>, for scrolls version: <?php echo($row['meta']) ?>, with a Score of <?php echo($row['vote']) ?></small>
					</div>
				</div>
			<!--Scrolls list-->
			<div class="news_wall right">
				
					<div class="modern clearfix border-radius-bottom-none">
						  <div class="left">
							<?php if ($row['growth'] == 1) {
								echo('<i class="icon-growth"></i>');
							}
							
							if ($row['decay'] == 1) {
								echo('<i class="icon-decay"></i>');
							}
							
							if ($row['tOrder'] == 1) {
								echo('<i class="icon-order"></i>');
							}
							
							if ($row['energy'] == 1) {
								echo('<i class="icon-energy"></i>');
							}
							
							if ($row['wild'] == 1) {
								echo('<i class="icon-wild"></i>');
							}
							 ?>	
						</div>
						<div class="right">
							<div class="left"><i class="icon-scrolls"></i></div>
							<div class="left" style="margin-left: 5px; margin-top: 1px;"><?php echo($row['scrolls']) ?></div>
						</div>
					</div>
				
				
				<?php include("inc_/curve.php"); ?>
				<?php echo(addBigColoredCurve($row['id'])); ?>
				<?php 
				
				$json = $row['JSON'];
				$data = json_decode($json, TRUE);
				if ($data['msg'] == "success") { 
					
					$curve = array(
						1 => intval(0),
						2 => intval(0),
						3 => intval(0),
						4 => intval(0),
						5 => intval(0),
						6 => intval(0),
						7 => intval(0),
						8 => intval(0),
						9 => intval(0),
						10 => intval(0),
						11 => intval(0),
						12 => intval(0),
						13 => intval(0)
					);
					$listOfScrolls = array();
					
					for ($i = 0; $i < count($data['data']['scrolls']); $i++) {
					
						$query = $db->prepare("SELECT * FROM scrollsCard WHERE id=:id");
						$arr = array(
								'id' => $data['data']['scrolls'][$i]['id']
							);
						
						$x->arrayBinder($query, $arr);
						$query->execute();		
						$card = $query->fetch(PDO::FETCH_ASSOC);
					  
					  	$singelScroll = array(
					  		2 => $card['name'],
					  		3 => $card['image'],
					  		4 => $data['data']['scrolls'][$i]['c'],
					  		5 => $card['costorder'],
					  		6 => $card['costgrowth'],
					  		7 => $card['costdecay'],
					  		8 => $card['costenergy'],
					  		9 => $card['description'],
					  		10 => $card['passiverules_1'],
					  		11 => $card['passiverules_2'],
					  		12 => $card['passiverules_3'],
					  		13 => $card['types'],
					  		14 => $card['kind']
					  		
					  	);
					  
					  	array_push($listOfScrolls, $singelScroll);
					  
					 	if ($card['rarity'] == 0) {
					 		$scrollClass = "mR";
					 	}
					 	if ($card['rarity'] == 1) {
					 		$scrollClass = "mR";
					 	}
					 	if ($card['rarity'] == 2) {
					 		$scrollClass = "mR";
					 	}
					}
				} 
				function my_sort($a,$b)
				{
				if ($a==$b) return 0;
				   return ($a<$b)?-1:1;
				}
				
				
				usort($listOfScrolls, "my_sort");

				?>
					

					<?php for ($j = 0; $j < count($listOfScrolls); $j++) { ?>
						
				<div class="clearfix" id="ScrollsNr<?php echo($listOfScrolls[$j][3]); ?>">
					<div id="" class="deckScrollList <?php echo($scrollClass) ?> " style="overflow: hidden;"> 
						 <span class="left">
						 <?php if (!empty($listOfScrolls[$j][5])) { ?>
							<span class="resource"><i class="icon-order small"></i><?php echo($listOfScrolls[$j][5]) ?></span>
						<?php } ?>
						<?php if (!empty($listOfScrolls[$j][6])) { ?>
							<span class="resource"><i class="icon-growth small"></i><?php echo($listOfScrolls[$j][6]) ?></span>
						<?php } ?>
						<?php if (!empty($listOfScrolls[$j][7])) { ?>
							<span class="resource"><i class="icon-decay small"></i><?php echo($listOfScrolls[$j][7]) ?></span>
						<?php } ?>
						<?php if (!empty($listOfScrolls[$j][8])) { ?>
							<span class="resource"><i class="icon-energy small"></i><?php echo($listOfScrolls[$j][8]) ?></span>
						<?php } ?>
						</span>
						
						<span class="left"><?php echo($listOfScrolls[$j][2]); ?></span>

						<span class="right">
							<a href="<?php echo($main) ?>resources/cardImages/<?php echo($listOfScrolls[$j][3]) ?>.png" data-title="<?php echo($listOfScrolls[$j][2]); ?>, x<?php echo($listOfScrolls[$j][4]); ?>" data-lightbox="Scrolls"><img class="listScroll" src="<?php echo($main) ?>resources/cardImages/<?php echo($listOfScrolls[$j][3]) ?>.png" alt="" /></a>
						</span>
						
						<span class="right" style="margin-right: 20px;">x<?php echo($listOfScrolls[$j][4]); ?></span>
					</div>
					<div class="deckScrollsInfo hidden">
						<?php if (!empty($listOfScrolls[$j][13])) {
							echo("<p>".$listOfScrolls[$j][14].": ".$listOfScrolls[$j][13]."</p>");
						} ?>
					
						<?php if (!empty($listOfScrolls[$j][10])) {
							echo("<p>* ".$listOfScrolls[$j][10]."</p>");
						} ?>
						<?php if (!empty($listOfScrolls[$j][11])) {
							echo("<p>* ".$listOfScrolls[$j][11]."</p>");
						} ?>
						<?php if (!empty($listOfScrolls[$j][12])) {
							echo("<p>* ".$listOfScrolls[$j][12]."</p>");
						} ?>
						<p><?php echo($listOfScrolls[$j][9]); ?></p>
					</div>
					</div>
					<?php } ?>
 			</div>
			<!--Desc and comments-->
			<div class="news left">
				<div class="clearfix">
					<?php 
						function makeClickableLinks($s) {
						  return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
						}
					 ?>
				
					<form method="post" action="">
						<div class="div-4">
							<a href="<?php echo($main."deckbuilder/".$row['id']) ?>" class="btn-modern btn-no-margin">Send to deckbuilder</a>
						</div>
						<div class="div-4"><input class="textbox full" type="text" name="deck_title" value="<?php echo($row['deck_title']) ?>" /></div>
						<div class="div-4">
							
							<?php if ($row['isHidden'] == 1) { ?>
								<input type="checkbox" checked name="isHidden" id="isHidden" value="1" />
							<?php } else { ?>
								<input type="checkbox" name="isHidden" id="isHidden" value="1" />
							<?php } ?>
							<label for="isHidden">Make deck hidden, so only you can see it (Direct link still works for everyone)</label>
						</div>
						<div class="div-4">
							<label>Change Game version for deck</label><br />
							<select name="meta">
								<option selected="selected" value="<?php echo($row['meta']) ?>"><?php echo($row['meta']) ?></option>
								<option value="0.125.0">0.125.0 (Latest, Test Server)</option>
								<option selected value="0.124.0">0.124.0 (Latest, Main Server)</option>
								<option value="0.123.0">0.123.0</option>
								<option value="0.122.0">0.122.0</option>
								<option value="0.121.0">0.121.0</option>
								<option value="0.119.1">0.119.1</option>
								<option value="0.117">0.117</option>
								<option value="0.112.2">0.112.2</option>
								<option value="0.110.5">0.110.5</option>
								<option value="0.105">0.105</option>
								<option value="0.103">0.103</option>
								<option value="0.97">0.97</option>
							</select>
						</div>
						<div class="div-4">
							<textarea class="ckeditor" id="editor" name="html"><?php echo($row['text']) ?></textarea>
						</div>
						<div class="div-4">
							<input type="submit" name="submit" value="Save" class="btn-modern" />
						</div>
					</form>
				</div>
			</div>
			
		</div>
	</div>
	<?php include("inc_/footer.php"); ?>
	
	<script>
	$(function() {
		$("[id*=ScrollsNr]").click(function() {
			$(this).find("div").next("div").toggle();
		});
	});
	
	</script>
</body>
</html>