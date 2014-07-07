<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
$x = new xClass();
session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}


$query = $db->prepare("SELECT * FROM scrollsCard ORDER BY name DESC");


$query->execute();

?>

<!DOCTYPE html>
<html lang="en">
	<?php include('inc_/head.php') ?>
<body>
	<?php include('inc_/menu.php') ?>
	<div class="body" id="blog">
		
		<div class="container">
			<div class="spellbook">
				<div class="leftside"></div>
				<div class="spells">
					<ul>
						<?php 
							while ($scroll = $query->fetch(PDO::FETCH_ASSOC)) { ?>
								<li class="spellScroll"
								
								data-d="<?php echo($scroll['description']) ?>"
								data-sound="<?php echo($scroll['sound']) ?>"
								data-name="<?php echo($scroll['name']) ?>"
								data-type="<?php echo($scroll['kind']) ?>"
								data-sub-type="<?php echo($scroll['types']) ?>"
								
								data-set="<?php echo($scroll['scrollsSet']) ?>"
								data-rarity="<?php echo($scroll['rarity']) ?>"
								data-hp="<?php echo($scroll['hp']) ?>"
								data-ap="<?php echo($scroll['ap']) ?>"
								data-cd="<?php echo($scroll['ac']) ?>"

								
								><img src="<?php echo($main) ?>resources/cardImages/<?php echo($scroll['image']) ?>.png" alt="" /></li>
							<?php } ?>
						
					</ul>
				</div>
				<div class="rightside"></div>
			</div>
			
			<div class="div-4">
				<div class="div-4">
					<h1 id="scroll_name"></h1>
					<small class="" id="kind_types"></small>
				</div>
				<div class="span-2 left">
					<img  id="card_art" src="" class="div-4" alt="" />
				</div>
				
				<div class="span-6 indent">
					<div class="div-4">
						<p id="unit_text"></p>
					</div>
					<div id="sound_div" class="hidden div-4 left">
						<div class="div-4">
							<span id="play_sound" class="btn-modern">Play Sound</span>
						</div>
						
					</div>
				</div>
			</div>
			
		</div>
	</div>
<?php include("inc_/footer.php"); ?>
<script>
	$(function() {
		var sound_file = ""
		var sound = document.createElement("audio");
		
		$("[class^=spellScroll]").click(function() {
			console.log("clicked on scroll: "+$(this).attr("data-name"));
			sound_file = "<?php echo($main) ?>audio/"+$(this).attr("data-sound")+".ogg";
			
			sound.setAttribute('src', sound_file);
			console.log("Loading "+sound_file+"...");
			sound.load();
			
			var ap = $(this).attr("data-ap");
			var hp = $(this).attr("data-hp");
			var cd = $(this).attr("data-cd");
			
			var set = $(this).attr("data-set");
			
			var kind = $(this).attr("data-type");
			var name = $(this).attr("data-name");
			var unit_text = name + " is a " + kind.toLowerCase() + " with " + ap + " attack, " + cd + " countdown and " + hp + " HP <br /> " + name + " is a part of set " + set;
			
			if (sound_file == "<?php echo($main) ?>audio/.ogg") {
				$("#sound_div").hide();
			} else {
				$("#sound_div").show();
			}
			
			$("#scroll_name").text(name);
			$("#card_art").attr("src", $(this).find("img").attr("src"));
			
			$("#kind_types").text(kind+": "+$(this).attr("data-sub-type"));
			
			
			$("#unit_text").html(unit_text);
			
		});
		
		$("#play_sound").click(function() {
			if (sound_file != "audio/.ogg") {
				sound.play(); 
			}
		});
		
	
	});
</script>
</body>
</html>