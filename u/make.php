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
	<link rel="icon" type="image/png" href="<?php echo($main) ?>/img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="<?php echo($main) ?>jquery.js"></script>	 
	<script src="<?php echo($main) ?>plugins/ckeditor/ckeditor.js"></script>	
		
</head>
<body>
<?php include('../inc_/menu.php'); ?>
	 <div class="container">
	 	<div class="wall_big">
	 	<form method="post" action="<?php echo($main) ?>u/scroll.php">
	 		<div class="div-4">
	 			<p>Resource</p>
					<div class="div-4">
						<input id="res_0" checked type="radio" name="res" value="0" />
						<label for="res_0" class="hand">Preset</label>
						<input id="res_1" type="radio" name="res" value="1" />
						<label for="res_1" class="hand">Custom</label>
					</div>
			
	 			<ul class="badge-icon-admin" id="type_preset">
						
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
						<li>
							<input id="type_6" <?php if (isset($fanScroll) && $fanScroll['ressource'] == 6) {echo("checked");} ?> type="radio" name="type" id="badge-6" value="6" class="hidden" />

						</li>
	 				
	 			</ul>
	 			
	 		</div>
	 		<div class="div-4 hidden" id="colorChanger">
	 			<p>Choose Colors</p>
	 			
	 			<div class="span-4">
		 			<div class="div-4">
		 				<p>Red: <span id="rText">0</span></p>
		 				<div class="colorBox small left span-2" id="r0" style="background-color: rgb(0, 0, 0);"></div>
		 					<input type="range" id="r" name="colorR" class="left span-5" value="0" max="255" min="0" />
		 				<div class="colorBox small left span-2" id="r255" style="background-color: rgb(255, 0, 0);"></div>
		 			</div>
		 			<div class="div-4">
		 				<p>Green: <span id="gText">0</span></p>
		 				<div class="colorBox small left span-2" id="g0" style="background-color: rgb(0, 0, 0);"></div>
		 					<input type="range" id="g" name="colorG" class="left span-5" value="0" max="255" min="0" />
		 				<div class="colorBox small left span-2" id="g255" style="background-color: rgb(0, 255, 0);"></div>
		 			</div>
		 			<div class="div-4">
		 				<p>Blue: <span id="bText">0</span></p>
		 				<div class="colorBox small left span-2" id="b0" style="background-color: rgb(0, 0, 0);"></div>
		 					<input type="range" id="b" name="colorB" class="left span-5" value="0" max="255" min="0" />
		 				<div class="colorBox small left span-2" id="b255" style="background-color: rgb(0, 0, 255);"></div>
		 			</div>
	 			</div>
	 			<div class="span-2">
	 				<div class="colorBox left" id="colorBox" style="background-color: rgb(0, 0, 0);"></div>
	 			</div>
	 		</div>
			<div class="div-4">
				<p>Title</p>
				<input type="text" id="scroll_title" class="textbox div-2" name="text" value="<?php if (isset($fanScroll)) {echo($fanScroll['title']);} ?>" placeholder="Title"/>
			</div>
	 		<div class="div-4">
	 			<p>Rarity</p>
		 		<input type="radio" <?php if (isset($fanScroll) && $fanScroll['rarity'] == 0) {echo("checked");} ?> name="rarity" value="0" id="rarity-1" /><label class="hand" for="rarity-1"> Common</label>
		 		<input type="radio" <?php if (!isset($fanScroll)) {echo("checked");} ?> <?php if (isset($fanScroll) && $fanScroll['rarity'] == 1) {echo("checked");} ?> name="rarity" value="1" id="rarity-2" /><label class="hand" for="rarity-2"> Uncommon</label>
		 		<input type="radio" <?php if (isset($fanScroll) && $fanScroll['rarity'] == 2) {echo("checked");} ?> name="rarity" value="2" id="rarity-3" /><label class="hand" for="rarity-3"> Rare</label>
		 	</div>
		 	<div class="div-4">
		 		<div class="span-4">
		 			<p>Cost</p>
		 			<label class="select">
		 			<select id="cost" name="nr">
		 					<?php if (isset($fanScroll)) { ?>
		 					<option selected value="<?php echo($fanScroll['cost']) ?>">Cost <?php echo($fanScroll['cost']) ?></option>
		 					<?php } ?>
		 				<?php for ($i = 0; $i < 10; $i++) { ?>
		 					<option value="<?php echo($i) ?>">Cost <?php echo($i) ?></option>
		 				<?php } ?>
		 			</select>
		 			</label>
		 		</div>
		 		<div class="span-4">
		 			<p>Tier</p>
		 			<label class="select">
			 			<select id="tier" name="tier">
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
			 		
		 		
		 		<?php for ($i = 0; $i <= 25; $i++) { ?>
		 				<li>
		 					
		 					<input type="radio" <?php if ($i == 0 && !isset($fanScroll)) {
		 						echo("checked");
		 					} ?>  name="cardImage" id="art-<?php echo($i) ?>" value="spoilerArt/<?php echo($i) ?>" />
		 					
		 					<label for="art-<?php echo($i) ?>" class="checkbox" style="background-image: url(<?php echo($main) ?>resources/cardImages/spoilerArt/<?php echo($i) ?>.png);">
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
		 		<input type="text" class="textbox div-2" id="kin" name="kin" value="<?php if (isset($fanScroll)) {echo($fanScroll['sub_type']);} ?>" placeholder="Sub-Type"/>
		 		
			</div>
			<div class="div-4" id="stats">
				<div class="span-3">
					<p>Attack</p>
					<input type="number" class="textbox div-2" id="ap" name="ap" value="<?php if (isset($fanScroll)) {echo($fanScroll['ap']);} ?>" min="-1" max="9" placeholder="Attack"/>
				</div>
				<div class="span-3">
					<p>Countdown</p>
					<input type="number" class="textbox div-2" id="cd" name="cd" value="<?php if (isset($fanScroll)) {echo($fanScroll['cd']);} ?>" min="-1" max="9" placeholder="Countdown"/>
				</div>
				<div class="span-3">
					<p>Health</p>
					<input type="number" class="textbox div-2" id="hp" name="hp" value="<?php if (isset($fanScroll)) {echo($fanScroll['hp']);} ?>" min="-1" max="9" placeholder="Health"/>
				</div>
			</div>
			<div class="div-4">
				<div class="span-3">	
					<p>Trait 1</p>
					<input type="text" class="textbox div-2" name="p" value="<?php if (isset($fanScroll)) {echo($fanScroll['passive_1']);} ?>" placeholder="Trait 1"/>
				</div>
				<div class="span-3">
					<p>Trait 2</p>
					<input type="text" class="textbox div-2"  name="pa" value="<?php if (isset($fanScroll)) {echo($fanScroll['passive_2']);} ?>" placeholder="Trait 2"/>
				</div>
				<div class="span-3">
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
				<textarea name="de" class="textarea div-4" maxlength="280" placeholder="Desciption"><?php if (isset($fanScroll)) {echo($fanScroll['description']);} ?></textarea>
			</div>
			
			<div class="div-3">
				<p>Lore</p>
				<textarea name="lore" class="textarea div-4"  maxlength="140" placeholder="Lore"><?php if (isset($fanScroll)) {echo($fanScroll['lore']);} ?></textarea>
			</div>
			
			<?php if (isset($fanScroll)){ ?>
				<div class="div-4">
					<div class="div-4">
						<p>When Saving over an existing scroll, it takes 2-5min for change to show up.</p>
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
		<div class="wall_small">
			<h1>Preview (Work in progress)</h1>
			<div id="fixed">
				<div class="scrollTitle">Title</div>
				<div class="scrollSub">Sub</div>
				<div class="scrollPlate">
					<div class="scrollType"></div>
					<div class="scrollCost"></div>
				</div>
				<div class="scrollArt"></div>
				<div class="scrollBackground"></div>
				<div class="scrollTier"></div>
				<div class="scrollStats">
					<div class="scrollAP"></div>
					<div class="scrollCD"></div>
					<div class="scrollHP"></div>
				</div>
			</div>
		</div>
	 </div>

<?php include('../inc_/footer.php'); ?>
<script>
$(function() {
	updateScroll()
	function getScrollType(i) {
		scroll = [
		 "scroll/256_decay_result.png",
		 "scroll/256_energy_result.png",
		 "scroll/256_growth_result.png",
		 "scroll/256_order_result.png",
		 "scroll/256_special_result.png",
		 "scroll/256_chaos_result.png",
		 "scroll/256_custome_result.png"
		];
		return scroll[i];
	}
	
	function getTier(i) {
		scroll = [
		 "",
		 "scroll/crafting_3_3_result.png",
		 "scroll/crafting_3_2_result.png"
		];
		return scroll[i];
	}
	
	function getCost(i) {
		if (i < 0) {
			number = "scroll/yellow_0_result.png";
		}
		else if (i > 9) {
			number = "scroll/yellow_9_result.png";
		} else {
			number = "scroll/yellow_" + i + "_result.png";
		}
	
		return number;
	}
	
	function getNumber(i) {
		if (i == -1) {
			number = "scroll/scroll_numbers____result.png";
		} else {
			number = "scroll/scroll_numbers__" + i + "_result.png";
		}
	
		return number;
	}
	
	function getScollBase(faction, rarity) {
		var scroll = [
		 "scroll/scrolls__scrollbase_decay_" + rarity + "_result.png",
		 "scroll/scrolls__scrollbase_energy_" + rarity + "_result.png",
		 "scroll/scrolls__scrollbase_growth_" + rarity + "_result.png",
		 "scroll/scrolls__scrollbase_order_" + rarity + "_result.png",
		 "scroll/scrolls__scrollbase_Wild_" + rarity + "_result.png",
		 "scroll/scrolls__scrollbase_Chaos_" + rarity + "_result.png",
		  "scroll/scrolls__scrollbase_neutral_" + rarity + ".png",
		];
		
		return scroll[faction];
	}

	function updateScroll() {
		var url = "<?php echo($main) ?>";
		var scroll_art = $(".scrollArt");
		var scroll_background = $(".scrollBackground");
		var scroll_title = $(".scrollTitle");
		var scroll_cost = $(".scrollCost");
		var scroll_type = $(".scrollType");
		
		var scroll_tier = $(".scrollTier");
		var scroll_sub = $(".scrollSub");
		var scroll_stat = $(".scrollStats");
		
		var scroll_AP = $(".scrollAP");
		var scroll_CD = $(".scrollCD");
		var scroll_HP = $(".scrollHP");
		
		
		var art = url + "resources/cardImages/" + $("input[name=cardImage]:checked").val() + ".png";
		var base = url + "u/" + getScollBase($("input[name=type]:checked").val(), $("input[name=rarity]:checked").val());
		var title = $("#scroll_title").val()
		
		var type = url + "u/" + getScrollType($("input[name=type]:checked").val());
		var cost = url + "u/" + getCost($("#cost").val());
		var tier = url + "u/" + getTier($("#tier").val());
		var sub_type = $("input[name=scrollType]:checked").val();
		var sub = $("#kin").val();
		
		var ap = url + "u/" + getNumber($("#ap").val());
		var cd = url + "u/" + getNumber($("#cd").val());
		var hp = url + "u/" + getNumber($("#hp").val());
		
		if (sub_type == 0 || sub_type == 1) {
			$(scroll_stat).show()
		} else {
			$(scroll_stat).hide()
		}
		
		
		if (sub_type == 0) {
			sub_type = "CREATURE"
		}
		if (sub_type == 1) {
			sub_type = "STRUCTURE"
		}
		if (sub_type == 2) {
			sub_type = "SPELL"
		}
		if (sub_type == 3) {
			sub_type = "ENCHANTMENT"
		}
		if (sub != "") {
			sub_type += ": ";
		}
		
		
		

		$(scroll_tier).css("background-image", "url('"+tier+"')");
		$(scroll_art).css("background-image", "url('"+art+"')");
		$(scroll_type).css("background-image", "url('"+type+"')");
		$(scroll_cost).css("background-image", "url('"+cost+"')");
		
		$(scroll_background).css("background-image", "url('"+base+"')");
		$(scroll_title).text(title);
		$(scroll_sub).text(sub_type + sub);
		
		$(scroll_AP).css("background-image", "url('"+ap+"')");
		$(scroll_CD).css("background-image", "url('"+cd+"')");
		$(scroll_HP).css("background-image", "url('"+hp+"')");
	}
	
	$("input[name=cardImage]:radio, input[name=type]:radio, input[name=rarity]:radio, #cost, #tier, input[name=scrollType]:radio,  #ap, #hp, #cd").change(function () {
		updateScroll();
	});
	$("#scroll_title, #kin, #ap, #hp, #cd").keyup(function () {
		updateScroll();
	});
	
	
	//$('html, body').animate({scrollTop: dest_pos}, 1000);
	$(document).scroll(function () {
		var height = $(document).height()
		var footerHeight = $("#footer").height();
		var div = $("#fixed");
		var divHeight = $("#fixed").height()
		var scrollLoc = $(document).scrollTop()
		if (scrollLoc > height - footerHeight - divHeight - 200) {
			
		} else {
			if (scrollLoc < 100) {
				
			} else {
				$(div).css("margin-top", scrollLoc-100);
			}
			
		}
		
		
	});
	
	
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
	
	var lastChecked = 0;
	$("input[name=res]:radio").change(function() {
		if ($(this).val() == 1) {
			console.log(0);
			lastChecked = $("input[name=type]:checked").val();
			
			$("#type_6").click();
		} else {

			$("input:radio[name=type][value="+lastChecked+"]").click();
		}
	});
	
	$("input[name=type]:radio").change(function() {
		if ($(this).val() == 6) {
			$("#colorChanger").slideDown();
			$("#type_preset").slideUp();
		} else {
			$("#colorChanger").slideUp();
			$("#type_preset").slideDown();
		}
	});
	//.colorBor, #r, #g, #b
	$("#r").mousemove(function() {
		changeColor();
	});
	$("#g").mousemove(function() {
		changeColor();
	});
	$("#b").mousemove(function() {
		changeColor();
	});
	
	$("#r").change(function() {
		changeColor();
	});
	$("#g").change(function() {
		changeColor();
	});
	$("#b").change(function() {
		changeColor();
	});
	
	function changeColor() {
		var r = $("#r").val();
		var g = $("#g").val();
		var b = $("#b").val();
		
		$("#colorBox").css("background-color", "rgb("+r+", "+g+", "+b+")");
	
		
		$("#r0").css("background-color", "rgb(0, "+g+", "+b+")");
		$("#r255").css("background-color", "rgb(255, "+g+", "+b+")");
		
		$("#g0").css("background-color", "rgb("+r+", 0, "+b+")");
		$("#g255").css("background-color", "rgb("+r+", 255, "+b+")");
		
		$("#b0").css("background-color", "rgb("+r+", "+g+", 0)");
		$("#b255").css("background-color", "rgb("+r+", "+g+", 255)");
	
		$("#rText").text(r);
		$("#gText").text(g);
		$("#bText").text(b);
	}
});

</script>
</body>
</html