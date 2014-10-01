<?php
	include('../../admin/mysql/connect.php');
	include('../../admin/mysql/function.php');
	include('../../admin/mysql/scrolls.php');
	include('../../admin/mysql/deck.php');
	$x = new xClass();
	$scroll = new scrolls();
	$deckData = new deck();
	
	
	$query = $db->prepare("SELECT * FROM scrollsCard WHERE id=:id");
	$arr = array(
			'id' => $_POST['scroll']
		);
	$x->arrayBinder($query, $arr);
	
	if ($query->execute()) {
		$scroll = $query->fetch(PDO::FETCH_ASSOC);
	
	
	if (!empty($scroll['costorder'])) {
		$scrollType = "order";
		$scrollCost = $scroll['costorder'];
		
	} elseif (!empty($scroll['costgrowth'])) {
		$scrollType = "growth";
		$scrollCost = $scroll['costgrowth'];
		
	} elseif (!empty($scroll['costenergy'])) {
		$scrollType = "energy";
		$scrollCost = $scroll['costenergy'];
	
	} elseif (!empty($scroll['costdecay'])) {
		$scrollType = "decay";
		$scrollCost = $scroll['costdecay'];
	}
	
	if ($scroll['rarity'] == 0) {
		$rareity = "Common";
	} elseif ($scroll['rarity'] == 1) {
		$rareity = "Uncommon";
	} elseif ($scroll['rarity'] == 2) {
		$rareity = "Rare";
	}
	
	$queryTotal = $db->prepare("SELECT * FROM decks WHERE isHidden = 0 AND JSON LIKE '%\"id\":".$scroll['id'].",%'");
	$queryTotal->execute();
	
	$totalDecks = $queryTotal->rowCount();
	
	

?>

<div class="library-info clearfix">
	<div class="div-4">
		<h1 class="color-white left"><?php echo($scrollCost) ?> <i class="icon-<?php echo($scrollType) ?> big" style="margin-bottom: -4px;"></i> <?php echo($scroll['name']) ?> <small><?php echo($rareity." ".$scroll['kind'].": ".$scroll['types']) ?></small></h1>
		<button id="close" class="btn-modern right">&times;</button>
	</div>
	<div class="div-4">
		<div class="span-4">
			<div class="div-4">
				<img class="left" src="../resources/cardImages/<?php echo($scroll['image']) ?>.png" alt="" />
				<div class="left div-4">
			<?php if ($scroll['kind'] == "CREATURE" || $scroll['kind'] == "STRUCTURE" ) { ?>
						<div class="scrolls_statsbar_lib" style="display: block;">
						 	<h1 id="scroll-ap-lib"><?php echo($scroll['ap']) ?></h1>
						 	<h1 id="scroll-ac-lib"><?php echo($scroll['ac']) ?></h1>
							<h1 id="scroll-hp-lib"><?php echo($scroll['hp']) ?></h1>
						</div>
					<?php } ?>
					<ul class="left clear">
					<?php 
					if (!empty($scroll['passiverules_1'])) {
						echo("<li class='textFont'>*".$scroll['passiverules_1']."</li>");
					}
					if (!empty($scroll['passiverules_2'])) {
						echo("<li class='textFont'>*".$scroll['passiverules_2']."</li>");
					}
					if (!empty($scroll['passiverules_3'])) {
						echo("<li class='textFont'>*".$scroll['passiverules_3']."</li>");
					} ?>
					</ul>
					<p class="sFont left clear textFont" style="width: 300px;"><?php echo($scroll['description']) ?></p>
					<p class="sFont left clear textFont" style="width: 300px;">A part of set <?php echo($scroll['scrollsSet']) ?></p>
					
					
				</div>
			</div>
		</div>
		<div class="span-4">
			<h2 class="left clear color-white right" style="width: 350px;">Top decks with <?php echo($scroll['name']) ?> (<?php echo($totalDecks); ?>)</h2>
			
			<div class="div-4  right" style="width: 350px;">
				<?php 
					$query = $db->prepare("SELECT * FROM decks WHERE isHidden = 0 AND JSON LIKE '%\"id\":".$scroll['id'].",%' ORDER BY meta DESC, vote DESC, time DESC LIMIT 2");
					
					
					
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
				<?php if ($totalDecks > 2) { ?>
					<button class="btn-modern" style="width: 100%;" id="show-all-decks" data-id="<?php echo($scroll['id']) ?>">Show all decks</button>
				<?php } ?>
			</div>
			
		</div>
	</div>

<div class="div-4">
	<h3 class="color-white">Related Scrolls</h3>
	
	<?php  
		if (!empty($scroll['costorder'])) {
			$typeString = "costorder";
			
		} elseif (!empty($scroll['costgrowth'])) {
			$typeString = "costgrowth";
			
		} elseif (!empty($scroll['costenergy'])) {
			$typeString = "costenergy";
			
		} elseif (!empty($scroll['costdecay'])) {
			$typeString = "costdecay";
			
		}
	$query = $db->prepare("SELECT * FROM scrollsCard WHERE kind = :type AND name != :name AND types LIKE '%".$scroll['types']."%' ORDER BY ".$typeString." DESC, kind, types LIMIT 5");
		
		$arr = array(
				'type' => $scroll['kind'],
				'name' => $scroll['name']
			);
		$x->arrayBinder($query, $arr);
		
		if ($query->execute()) {

			while ($related = $query->fetch(PDO::FETCH_ASSOC)) {
				
		
	?>
	
	<div class="image-holder" data-id="<?php echo($related['id']) ?>">
		<img src="../resources/cardImages/<?php echo($related['image']) ?>.png" alt="" />
	</div>
	<?php }
		}
	 ?>
</div>
</div>
<? } else { ?>
	<div class="library-info clearfix">
		<p>Could Not load scroll</p>
	</div>
<?php } ?>