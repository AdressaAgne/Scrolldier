<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
$x = new xClass();

session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}
if (!isset($_SESSION['username'])) {
	header("location: ".$main."login.php?re=/deckbuilder/");
}
	

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolls - New Deck</title>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->	
</head>
<body style="padding-bottom: 0px;">	 
 	<div class="container">
 		<?php include('inc_/menu.php') ?>
 		<div class="wall_small">
 		 			<!-- 	scroll info	-->
 		 			<div class="modern scrollLibraryAbout clearfix">
 		 				<div id="clearfix left div-4">
 		 					
 		<!-- 					name, cost and ressource-->
 		 					<div class="div-4 left clearfix">
 		 						<h4 class="left" id="scroll-name"></h4>
 		 						<span class="right" id="scroll-type"></span><h4 class="right" id="scroll-cost"></h4>
 		 					</div>
 		 					
 		<!-- 					types and kind-->
 		 					<div class="div-4 left clearfix">
 		 						<span class="left" id="scroll-kind"></span> <span class="left" id="scroll-types"></span>
 		 					</div>
 		 					
 		<!-- 					passive rules-->
 		 					<div class="div-4 left clearfix">
 		 						<ul>
 		 							<li class="hidden" id="scroll-passive-1"></li>
 		 							<li class="hidden" id="scroll-passive-2"></li>
 		 							<li class="hidden" id="scroll-passive-3"></li>
 		 						</ul>
 		 					</div>
 		 					
 		 				</div>
 		<!-- 					desc--> 				
 		 				<div class="div-4" style="margin-top: 5px;">
 		 					<p class="left div-4" id="scroll-desc"></p>
 		 				</div>
 		 				<div class="scrolls_statsbar">
 		 					<h1 id="scroll-ap"></h1>
 		 					<h1 id="scroll-ac"></h1>
 		 					<h1 id="scroll-hp"></h1>
 		 				</div>
 		 			</div>
 		 			<!-- 	Curve	-->
 		 			<div class="mR deckScrollList clearfix">
 		 				<span id="totalScrolls"></span>
 		 				<button class="btn-modern btn-pagina right" id="clearDeck">Clear</button>
 		 			</div>
 		 			<!-- 	scrolls in deck	-->
 		 			<div class="">
 		 				<ul id="fullDeck">
 		 				
 		 				<?php if (!empty($_GET['deck'])) { ?>
 		 					<?php 
 		 					$query = $db->prepare("SELECT * FROM decks WHERE id=:id");
 		 					$arr = array(
 		 							'id' => $_GET['deck']
 		 						);
 		 					
 		 					$x->arrayBinder($query, $arr);
 		 					$query->execute();		
 		 					$row = $query->fetch(PDO::FETCH_ASSOC);
 		 					$listOfScrolls = array();			
 		 					$json = $row['JSON'];
 		 					$data = json_decode($json, TRUE);
 		 					if ($data['msg'] == "success") { 
 		 						
 		 						
 		 						
 		 						for ($i = 0; $i < count($data['data']['scrolls']); $i++) {
 		 						
 		 							$query = $db->prepare("SELECT * FROM scrollsCard WHERE id=:id");
 		 							$arr = array(
 		 									'id' => $data['data']['scrolls'][$i]['id']
 		 								);
 		 							
 		 							$x->arrayBinder($query, $arr);
 		 							$query->execute();		
 		 							$card = $query->fetch(PDO::FETCH_ASSOC);
 		 						  
 		 						  
 		 						  	$scrollsCost = 0;
 		 						  	$scrollType = "";
 		 						  	
 		 						  	if (!empty($card['costorder'])) {
 		 						  		
 		 						  		$scrollsCost = $card['costorder'];
 		 						  		$scrollType = "order";
 		 						  		
 		 						  	} elseif (!empty($card['costgrowth'])) {
 		 						  	
 		 						  		$scrollsCost = $card['costgrowth'];	
 		 						  		$scrollType = "growth";
 		 						  		
 		 						  	} elseif (!empty($card['costenergy'])) {
 		 						  	
 		 						  		$scrollsCost = $card['costenergy'];
 		 						  		$scrollType = "energy";
 		 						  	
 		 						  	}elseif (!empty($card['costdecay'])) {
 		 						  	
 		 						  		$scrollsCost = $card['costdecay'];
 		 						  		$scrollType = "decay";
 		 						  		
 		 						  	}
 		 						  
 		 						  	$singelScroll = array(
 		 						  		2 => $scrollsCost,
 		 						  		3 => $card['image'],
 		 						  		4 => $data['data']['scrolls'][$i]['c'],
 		 						  		5 => $card['name'],
 		 						  		6 => $scrollType,
 		 						  		7 => 0,
 		 						  		8 => 0,
 		 						  		9 => $card['description'],
 		 						  		10 => $card['passiverules_1'],
 		 						  		11 => $card['passiverules_2'],
 		 						  		12 => $card['passiverules_3'],
 		 						  		13 => $card['types'],
 		 						  		14 => $card['kind'],
 		 						  		15 => $card['id']
 		 						  		
 		 						  	);
 		 						  
 		 						  	array_push($listOfScrolls, $singelScroll);
 		 						  
 		 						}
 		 					} 
 		 					function my_sort($a,$b) {
 		 					if ($a==$b) return 0;
 		 					   return ($a<$b)?-1:1;
 		 					}
 		 									
 		 									
 		 					usort($listOfScrolls, "my_sort");
 		 				?>
 		 				<?php for ($j = 0; $j < count($listOfScrolls); $j++) { ?>
 		 				
 		 					<div id="scroll-in-deck" scroll-in-deck-id="<?php echo($listOfScrolls[$j][15]) ?>" class="deckScrollList mR" style="overflow: hidden;">
 		 						<span class="left">
 		 							<span class="resource"><i class="icon-<?php echo($listOfScrolls[$j][6]) ?> small"></i> <?php echo($listOfScrolls[$j][2]) ?></span>
 		 						</span>
 		 					
 		 						<span class="left" id="scroll-in-deck-name"><?php echo($listOfScrolls[$j][5]) ?></span>
 		 					
 		 						<span class="right">
 		 							<img class="listScroll" src="http://localhost/resources/cardImages/<?php echo($listOfScrolls[$j][3]) ?>.png" alt="">
 		 						</span>
 		 						<span class="right" id="quantity" style="margin-right: 20px;"><?php echo($listOfScrolls[$j][4]) ?></span>
 		 						<span class="right">x</span>
 		 					</div>
 		 					
 		 					
 		 					<?php } ?>
 					<?php } ?>
 		 					
 		 				</ul>
 		 			</div>
 		 		</div>
 		<div class="wall_big clearfix">
 <!-- 		Scrolls search	-->		
 		<div class="modern clearfix">
 			<input type="text" id="scrollSearch" class="textbox full" name="" value="" placeholder="Search..." />
 			<div class="chooseBox clearfix">
 				<div class="checkbox">
		 			<ul class="right typeIcons">
		 			  <li>
		 			      <input id="order_checkbox" data-for="order" checked type="checkbox" name="type_order" value="">
		 			      <label class="checkbox" for="order_checkbox"><i class="icon-order"></i></label> 
		 			      
		 			  </li>
		 			  <li>  
		 			      <input id="energy_checkbox" data-for="energy" checked type="checkbox"  name="type_energy" value="">
		 			      <label class="checkbox" for="energy_checkbox"><i class="icon-energy"></i></label> 
		 			     
		 			  </li>
		 			  <li>
		 			      <input id="growth_checkbox" data-for="growth" checked type="checkbox"  name="type_growth" value="">
		 			      <label class="checkbox" for="growth_checkbox"><i class="icon-growth"></i></label> 
		 			  </li>
		 			 <li class="">
		 			     <input id="decay_checkbox" data-for="decay" checked type="checkbox" name="type_decay" value="">
		 			     <label class="checkbox" class="" for="decay_checkbox"><i class="icon-decay"></i></label> 
		 			 </li>
		 			</ul>
		 		</div>
 			</div>
 			<div class="div-4">
 				<p>Filters: t:, c:, d:, ap:, cd:, hp:</p>
 			</div>
 		</div>
 
<!-- 		Scrolls library	-->
 		<div class="modern deckbuilderContainer">
 		<?php $query = $db->prepare("SELECT * FROM scrollsCard ORDER BY costorder, costgrowth, costenergy, costdecay, name");
 		$query->execute();
 		
 		while ($card = $query->fetch(PDO::FETCH_ASSOC)) { 
 			$scrollsCost = 0;
 			$scrollType = "";
 			
 			if (!empty($card['costorder'])) {
 				
 				$scrollsCost = $card['costorder'];
 				$scrollType = "order";
 				
 			} elseif (!empty($card['costgrowth'])) {
 			
 				$scrollsCost = $card['costgrowth'];	
 				$scrollType = "growth";
 				
 			} elseif (!empty($card['costenergy'])) {
 			
 				$scrollsCost = $card['costenergy'];
 				$scrollType = "energy";
 			
 			}elseif (!empty($card['costdecay'])) {
 			
 				$scrollsCost = $card['costdecay'];
 				$scrollType = "decay";
 				
 			}
 			if ($card['kind'] == "CREATURE" || $card['kind'] == "STRUCTURE") {
 				$statsbar = true;
 			} else {
 				$statsbar = false;
 			}
 			
 			
 			
 			if ($card['ac'] == -1) {
 				$cd = "-";
 			} else {
 				$cd = $card['ac'];
 			}
 			
 		?>
 			<div class="left img-margin" id="scroll"
 				data-scrolls-id="<?php echo($card['id']) ?>"
 				data-scrolls-image="<?php echo($card['image']) ?>"
 				data-scrolls-desc="<?php echo($card['description']) ?>"
 				data-scrolls-name="<?php echo($card['name']) ?>"
 				data-scrolls-attack="<?php echo($card['ap']) ?>"
 				data-scrolls-hp="<?php echo($card['hp']) ?>"
 				data-scrolls-cd="<?php echo($cd) ?>"
 				data-scrolls-type="<?php echo($scrollType) ?>"
 				data-scrolls-cost="<?php echo($scrollsCost) ?>"
 				data-scrolls-statsbar="<?php echo($statsbar) ?>"
 				data-scrolls-kind="<?php echo($card['kind']) ?>"
 				data-scrolls-types="<?php echo($card['types']) ?>"
 				data-scrolls-passive-1="<?php echo($card['passiverules_1']) ?>"
 				data-scrolls-passive-2="<?php echo($card['passiverules_2']) ?>"
 				data-scrolls-passive-3="<?php echo($card['passiverules_3']) ?>"
 				style="background-image: url(/resources/cardImages/<?php echo($card['image']) ?>.png);">
 				
 				<div id="scroll-top-name" class="hidden"><?php echo(strtolower($card['name'])) ?></div>
 				<div id="scroll-top-ap" class="hidden"><?php echo(strtolower($card['ap'])) ?></div>
 				<div id="scroll-top-hp" class="hidden"><?php echo(strtolower($card['hp'])) ?></div>
 				<div id="scroll-top-cd" class="hidden"><?php echo(strtolower($cd)) ?></div>
 				<div id="scroll-top-type" class="hidden"><?php echo(strtolower($scrollType)) ?></div>
 				<div id="scroll-top-cost" class="hidden"><?php echo(strtolower($scrollsCost)) ?></div>
 				<div id="scroll-top-types" class="hidden"><?php echo(strtolower($card['kind'])) ?> <?php echo(strtolower($card['types'])) ?></div>
 				<div id="scroll-top-desc" class="hidden"><?php echo(strtolower($card['passiverules_1'])) ?> <?php echo(strtolower($card['passiverules_2'])) ?> <?php echo(strtolower($card['passiverules_3'])) ?> <?php echo(strtolower($card['description'])) ?></div>
 			</div>
 			<?php } ?>
 			</div>
 			<div class="left modern div-4 div-no-margin">
 				<h3>Save Deck</h3>
 				<div class="div-4 div-margin">
 					<input type="textbox" id="jsonOUTPUT" class="textbox full" disabled name="json" value="" placeholder="Autogenerated JSON string" /><i class="icon-export"></i>
 				</div>
 				<div class="div-4 div-margin">
 					<label for="deckName">Deck name:</label><br />
 					<input type="textbox" id="deckName" class="textbox full" name="" value="" placeholder="deckname" />
 				</div>
 				<div class="div-4 div-margin">
 					<button class="btn-modern btn-pagina" type="submit" id="saveBtn" name="">Save</button>
 				</div>
 			</div>
 		</div>
 		
		
 		
 		
 	</div>
 	<?php include('inc_/footer.php') ?>
 <script src="<?php echo($main) ?>jquery.js"></script>	
 <script src="<?php echo($main) ?>deckbuilder.js" type="text/javascript"></script>
</body>
</html>