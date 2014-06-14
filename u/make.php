<?php 
include('../admin/mysql/connect.php');
include('../admin/mysql/function.php');
$x = new xClass();


session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}
if (!isset($_SESSION['username'])) {
	$actual_link = $_SERVER['REQUEST_URI'];
	header("location: ../login.php?re=".$actual_link);
}


if (isset($_POST['link']) && !empty($_POST['link'])) {
	
	$fan_query = $db->prepare("SELECT * FROM fanScrolls WHERE link=:link");	
			
		$fan_arr = array(
				'link' => $_POST['link']
			);
			
	
		$x->arrayBinder($fan_query, $fan_arr);
			
		$fan_query->execute();
		$fanScroll = $fan_query->fetch(PDO::FETCH_ASSOC);
	
}	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolls - Scroll Designer</title>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="icon" type="image/png" href="../img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="../jquery.js"></script>	 
	<script src="../plugins/ckeditor/ckeditor.js"></script>	
		
</head>
<body>
<?php include('../inc_/menu.php'); ?>
	 <div class="container">
	 	<form method="post" action="<?php echo($main) ?>u/scroll.php">
	 		<div class="div-4">
	 			<p>Resource</p>

	 			<ul class="badge-icon-admin">


						
	 					<li>
	 						<input <?php if (isset($fanScroll) && $fanScroll['ressource'] == 0) {echo("checked");} ?> type="radio" checked="" name="type" id="badge-0" value="0"  />
	 						<label for="badge-0" class="checkbox"><i class="icon-decay"></i></label>
	 					</li>
	 					<li>
	 						<input <?php if (isset($fanScroll) && $fanScroll['ressource'] == 1) {echo("checked");} ?> type="radio" name="type" id="badge-1" value="1" />
	 						<label for="badge-1" class="checkbox"><i class="icon-energy"></i></label>
	 					</li>
						<li>
							<input <?php if (isset($fanScroll) && $fanScroll['ressource'] == 2) {echo("checked");} ?> type="radio" name="type" id="badge-2" value="2" />
							<label for="badge-2" class="checkbox"><i class="icon-growth"></i></label>
						</li>
						<li>
							<input <?php if (isset($fanScroll) && $fanScroll['ressource'] == 3) {echo("checked");} ?> type="radio" name="type" id="badge-3" value="3" />
							<label for="badge-3" class="checkbox"><i class="icon-order"></i></label>
						</li>
						<li>
							<input <?php if (isset($fanScroll) && $fanScroll['ressource'] == 4) {echo("checked");} ?> type="radio" name="type" id="badge-4" value="4" />
							<label for="badge-4" class="checkbox"><i class="icon-wild"></i></label>
						</li>
						<li>
							<input <?php if (isset($fanScroll) && $fanScroll['ressource'] == 5) {echo("checked");} ?> type="radio" name="type" id="badge-5" value="5" />
							<label for="badge-5" class="checkbox"><img src="<?php echo($main) ?>u/scroll/256_chaos_result.png" alt="" width="26" /></label>
						</li>
	 				
	 			</ul>
	 			
	 		</div>
			<div class="div-4">
				<p>Title</p>
				<input type="text" class="textbox div-2" name="text" value="<?php if (isset($fanScroll)) {echo($fanScroll['title']);} ?>" placeholder="Title"/>
			</div>
	 		<div class="div-4">
	 			<p>Rarity</p>
		 		<input type="radio" <?php if (isset($fanScroll) && $fanScroll['rarity'] == 0) {echo("checked");} ?> name="rarity" value="0" id="rarity-1" /><label class="hand" for="rarity-1"> Common</label>
		 		<input type="radio" <?php if (!isset($fanScroll)) {echo("checked");} ?> <?php if (isset($fanScroll) && $fanScroll['rarity'] == 1) {echo("checked");} ?> name="rarity" value="1" id="rarity-2" /><label class="hand" for="rarity-2"> Uncommon</label>
		 		<input type="radio" <?php if (isset($fanScroll) && $fanScroll['rarity'] == 2) {echo("checked");} ?> name="rarity" value="2" id="rarity-3" /><label class="hand" for="rarity-3"> Rare</label>
		 	</div>
		 	<div class="div-4">
		 		<div class="span-2">
		 			<p>Cost</p>
		 			<label class="select">
		 			<select name="nr">
		 					<?php if (isset($fanScroll)) { ?>
		 					<option selected value="<?php echo($fanScroll['cost']) ?>">Cost <?php echo($fanScroll['cost']) ?></option>
		 					<?php } ?>
		 				<?php for ($i = 0; $i < 10; $i++) { ?>
		 					<option value="<?php echo($i) ?>">Cost <?php echo($i) ?></option>
		 				<?php } ?>
		 			</select>
		 			</label>
		 		</div>
		 		<div class="span-2">
		 			<p>Tier</p>
		 			<label class="select">
			 			<select name="tier">
			 				<?php if (isset($fanScroll)) { ?>
			 				<option selected="" value="<?php echo($fanScroll['tier']) ?>">Tier <?php echo($fanScroll['tier']+1) ?></option>
			 				<?php } ?>
			 				<option value="0">Tier 1</option>
			 				<option value="1">Tier 2</option>
			 				<option value="2">Tier 3</option>
			 			</select>
		 			</label>
		 		</div>
		 	</div>
		 	<div class="div-4">
		 		<p>Art</p>
		 		<ul class="badge-icon-scroll">
			 			<?php if (isset($fanScroll)) { ?>
						<li>
				 			<input type="radio" checked="" name="cardImage" id="art-selected" value="<?php echo($fanScroll['art']) ?>" />
				 			
				 			<label for="art-selected" class="checkbox" style="background-image: url(../resources/cardImages/<?php echo($fanScroll['art']) ?>.png);">
				 			</label>
			 			</li>
			 			<?php } ?>
			 		
		 		
		 		<?php for ($i = 0; $i <= 21; $i++) { ?>
		 				<li>
		 					
		 					<input type="radio" <?php if ($i == 0 && !isset($fanScroll)) {
		 						echo("checked");
		 					} ?>  name="cardImage" id="art-<?php echo($i) ?>" value="spoilerArt/<?php echo($i) ?>" />
		 					
		 					<label for="art-<?php echo($i) ?>" class="checkbox" style="background-image: url(../resources/cardImages/spoilerArt/<?php echo($i) ?>.png);">
		 					</label>
		 				</li>
		 			
		 		
		 		<?php } ?>
		 		</ul>
		 		
		 		
		 	</div>
		 	<div class="div-4">
		 		<p>Type</p>

		 		<input type="radio" <?php if (isset($fanScroll) && $fanScroll['type'] == 0) {echo("checked");} ?><?php if (!isset($fanScroll)) {echo("checked");} ?> checked="" name="scrollType" value="0" id="scrollType-0" /><label for="scrollType-0"> Creature</label>
		 		<input type="radio" <?php if (isset($fanScroll) && $fanScroll['type'] == 1) {echo("checked");} ?> name="scrollType" value="1" id="scrollType-1" /><label class="hand" for="scrollType-1"> Structure</label>
		 		<input type="radio" <?php if (isset($fanScroll) && $fanScroll['type'] == 2) {echo("checked");} ?> name="scrollType" value="2" id="scrollType-2" /><label class="hand" for="scrollType-2"> Spell</label>
		 		<input type="radio" <?php if (isset($fanScroll) && $fanScroll['type'] == 3) {echo("checked");} ?> name="scrollType" value="3" id="scrollType-3" /><label class="hand" for="scrollType-3"> Enchantment</label>	 		
		 	</div>
		 	<div class="div-4">
		 		<p>Sub-Type</p>
		 		<input type="text" class="textbox div-2" name="kin" value="<?php if (isset($fanScroll)) {echo($fanScroll['sub_type']);} ?>" placeholder="Sub-Type"/>
		 		
			</div>
			<div class="div-4" id="stats">
				<div class="span-2">
					<p>Attack</p>
					<input type="number" class="textbox div-2" name="ap" value="<?php if (isset($fanScroll)) {echo($fanScroll['ap']);} ?>" min="-1" max="9" placeholder="Attack"/>
				</div>
				<div class="span-2">
					<p>Countdown</p>
					<input type="number" class="textbox div-2" name="cd" value="<?php if (isset($fanScroll)) {echo($fanScroll['cd']);} ?>" min="-1" max="9" placeholder="Countdown"/>
				</div>
				<div class="span-2">
					<p>Health</p>
					<input type="number" class="textbox div-2" name="hp" value="<?php if (isset($fanScroll)) {echo($fanScroll['hp']);} ?>" min="-1" max="9" placeholder="Health"/>
				</div>
			</div>
			<div class="div-4">
				<div class="span-2">	
					<p>Trait 1</p>
					<input type="text" class="textbox div-2" name="p" value="<?php if (isset($fanScroll)) {echo($fanScroll['passive_1']);} ?>" placeholder="Trait 1"/>
				</div>
				<div class="span-2">
					<p>Trait 2</p>
					<input type="text" class="textbox div-2"  name="pa" value="<?php if (isset($fanScroll)) {echo($fanScroll['passive_2']);} ?>" placeholder="Trait 2"/>
				</div>
				<div class="span-2">
					<p>Trait 3</p>
					<input type="text" class="textbox div-2" name="pas" value="<?php if (isset($fanScroll)) {echo($fanScroll['passive_3']);} ?>" placeholder="Trait 3"/>
				</div>
			</div>
			
			<div class="div-4" id="ability_div">
				<input type="checkbox" <?php if (isset($fanScroll) && !empty($fanScroll['btn'])) {echo("checked");} ?> name="Ability_btn" id="Ability_btn" value="btn" />
				<label class="hand" for="Ability_btn">Add ability button</label>
				<div class="div-4 div-no-margin hidden" id="Ability_input">
					<p>Button text</p>
					<input type="text" class="textbox" name="Ability_btn_true" value="<?php if (isset($fanScroll)) {echo($fanScroll['btn']);} ?>" placeholder="Button text" />
				</div>
			</div>
			
			<div class="div-3">
				<p>Description</p>
				<textarea name="de" class="textarea" maxlength="280" placeholder="Desciption"><?php if (isset($fanScroll)) {echo($fanScroll['description']);} ?></textarea>
			</div>
			
			<div class="div-3">
				<p>Lore</p>
				<textarea name="lore" class="textarea"  maxlength="140" placeholder="Lore"><?php if (isset($fanScroll)) {echo($fanScroll['lore']);} ?></textarea>
			</div>
			
			<?php if (isset($fanScroll)){ ?>
				<div class="div-4">
					<div class="div-4">
						<p>When Save over existing scroll an existing scroll is take 2-5min to replace it</p>
					</div>
					<input type="radio" checked="" id="overWrtie-0" name="overWrtie" value="<?php echo($fanScroll['link']) ?>" />
					<label class="hand" for="overWrtie-0">Save over existing scroll</label>
					<input type="radio" id="overWrtie-1" name="overWrtie" value="" />
					<label class="hand" for="overWrtie-1">Save as new scroll</label>
				</div>
			<?php } ?>
			
			<div class="div-4">
				
				<input type="submit" name="" class="btn-modern btn-no-margin" value="Save to my library" />
				
				
			</div>
			
			
	 	</form>
	 
	 </div>

<?php include('../inc_/footer.php'); ?>
<script>
$(function() {
	$("input[name=scrollType]:radio").change(function () {

		if ($(this).val() < 2) {
			$("#stats").slideDown();
		} else {
			$("#stats").slideUp();
			
		}
	});
	
	
	$("#Ability_btn").change(function () {
		if ($(this).is(":checked")) {
			$("#Ability_input").slideDown();
			
		} else {
			$("#Ability_input").slideUp();
		}
	});
});

</script>
</body>
</html