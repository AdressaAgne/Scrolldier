<?php 
//include('../admin/mysql/connect.php');
//include('../admin/mysql/function.php');
//$x = new xClass();
//
//
//session_start();
//if (isset($_GET['logout'])) {
//	$x->logout();
//}
$main = "http://$_SERVER[HTTP_HOST]/";
	
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

	 <!--http://localhost/u/scroll.php?type=1&rarity=1&nr=4&tier=0&cardImage=1083&text=Header&scrollType=1&ap=5&hp=4&ac=4&p1=passive1&p2=passive2&p3=passive3&d=Description-->
	 <div class="container">
	 	<form method="post" action="scroll.php">
	 		<div class="div-4">
	 			<p>Resource</p>
	 			
	 			<ul class="badge-icon-admin">

	 					<li>
	 						<input type="radio" checked="" name="type" id="badge-0" value="0" />
	 						<label for="badge-0" class="checkbox"><i class="icon-decay"></i></label>
	 					</li>
	 					<li>
	 						<input type="radio" name="type" id="badge-1" value="1" />
	 						<label for="badge-1" class="checkbox"><i class="icon-energy"></i></label>
	 					</li>
						<li>
							<input type="radio" name="type" id="badge-2" value="2" />
							<label for="badge-2" class="checkbox"><i class="icon-growth"></i></label>
						</li>
						<li>
							<input type="radio" name="type" id="badge-3" value="3" />
							<label for="badge-3" class="checkbox"><i class="icon-order"></i></label>
						</li>
	 				
	 			</ul>
	 			
	 		</div>
			<div class="div-4">
				<p>Title</p>
				<input type="text" class="textbox div-2" name="text" value="" placeholder="Title"/>
			</div>
	 		<div class="div-4">
	 			<p>Rarity</p>
		 		<input type="radio" name="rarity" value="0" id="rarity-1" /><label for="rarity-1"> Common</label>
		 		<input type="radio" checked="" name="rarity" value="1" id="rarity-2" /><label for="rarity-2"> Uncommon</label>
		 		<input type="radio" name="rarity" value="2" id="rarity-3" /><label for="rarity-3"> Rare</label>
		 	</div>
		 	<div class="div-4">
		 		<div class="span-2">
		 			<p>Cost</p>
		 			<label class="select">
		 			<select name="nr">
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
			 				<option value="0">Tier 1</option>
			 				<option value="1">Tier 2</option>
			 				<option value="2">Tier 3</option>
			 			</select>
		 			</label>
		 		</div>
		 	</div>
		 	<div class="div-4">
		 		<p>Art</p>
		 		<ul class="badge-icon-admin">
		 	
		 		
		 		<?php for ($i = 0; $i < 16; $i++) { ?>
		 				<li>
		 					<input type="radio" <?php if ($i == 0) {
		 						echo("checked");
		 					} ?>  name="cardImage" id="art-<?php echo($i) ?>" value="spoilerArt/<?php echo($i) ?>" />
		 					<label for="art-<?php echo($i) ?>" class="checkbox"><img src="../resources/cardImages/spoilerArt/<?php echo($i) ?>.png" alt="" width="50px"/></label>
		 				</li>
		 			
		 		
		 		<?php } ?>
		 		</ul>
		 		
		 		
		 	</div>
		 	<div class="div-4">
		 		<p>Type</p>

		 		<input type="radio" checked="" name="scrollType" value="0" id="scrollType-0" /><label for="scrollType-0"> Creature</label>
		 		<input type="radio" name="scrollType" value="1" id="scrollType-1" /><label for="scrollType-1"> Structure</label>
		 		<input type="radio" name="scrollType" value="2" id="scrollType-2" /><label for="scrollType-2"> Spell</label>
		 		<input type="radio" name="scrollType" value="3" id="scrollType-3" /><label for="scrollType-3"> Enchantment</label>	 		
		 	</div>
		 	<div class="div-4">
		 		<p>Sub-Type</p>
		 		<input type="text" class="textbox div-2" name="kin" value="" placeholder="Sub-Type"/>
		 		
			</div>
			<div class="div-4">
				<div class="span-2">
					<p>Attack</p>
					<input type="number" class="textbox div-2" name="ap" value="1" min="-1" max="9" placeholder="Attack"/>
				</div>
				<div class="span-2">
					<p>Health</p>
					<input type="number" class="textbox div-2" name="hp" value="1" min="-1" max="9" placeholder="Health"/>
				</div>
				<div class="span-2">
					<p>Countdown</p>
					<input type="number" class="textbox div-2" name="cd" value="1" min="-1" max="9" placeholder="Countdown"/>
				</div>
			</div>
			<div class="div-4">	
				<p>Trait 1</p>
				<input type="text" class="textbox div-2" name="p" value="" placeholder="Trait 1"/>
			</div>
			<div class="div-4">
				<p>Trait 2</p>
				<input type="text" class="textbox div-2"  name="pa" value="" placeholder="Trait 2"/>
			</div>
			<div class="div-4">
				<p>Trait 3</p>
				<input type="text" class="textbox div-2" name="pas" value="" placeholder="Trait 3"/>
			</div>
			<div class="div-3">
				<p>Description</p>
				<textarea name="de" class="textarea"  placeholder="Desciption"></textarea>
			</div>
			<div class="div-4">
				<input type="submit" name="" class="btn-modern btn-no-margin" value="Make" />
			</div>
	 	</form>
	 
	 </div>


</body>
</html