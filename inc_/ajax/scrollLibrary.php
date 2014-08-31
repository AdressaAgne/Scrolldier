<?php
	include('../../admin/mysql/connect.php');
	include('../../admin/mysql/function.php');
	include('../../admin/mysql/scrolls.php');
	$x = new xClass();
	$scroll = new scrolls();
	
	
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

?>

<div class="library-info clearfix">
	<div class="div-4">
		<h1 class="color-white left"><?php echo($scrollCost) ?> <i class="icon-<?php echo($scrollType) ?> big" style="margin-bottom: -4px;"></i> <?php echo($scroll['name']) ?> <small><?php echo($scroll['kind'].": ".$scroll['types']) ?></small></h1>
		<button id="close" class="btn-modern right">&times;</button>
	</div>
	<div class="div-4">
		<div class="span-6">
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
					
					
				</div>
			</div>
		</div>
	
	</div>

<div class="div-4">
	<h3 class="color-white">Related Scrolls</h3>
	
	<?php  
		if (!empty($scroll['costorder'])) {
			$query = $db->prepare("SELECT * FROM scrollsCard WHERE kind = :type AND (costorder != 0) AND name != :name LIMIT 6");
			
		} elseif (!empty($scroll['costgrowth'])) {
		
			$query = $db->prepare("SELECT * FROM scrollsCard WHERE kind = :type AND (costgrowth != 0) AND name != :name LIMIT 6");
			
		} elseif (!empty($scroll['costenergy'])) {
		
			$query = $db->prepare("SELECT * FROM scrollsCard WHERE kind = :type AND (costenergy != 0) AND name != :name LIMIT 6");
			
		} elseif (!empty($scroll['costdecay'])) {
		
			$query = $db->prepare("SELECT * FROM scrollsCard WHERE kind = :type AND (costdecay != 0) AND name != :name LIMIT 6");
		
		}
	
		
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