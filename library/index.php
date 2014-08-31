<?php 
include('../admin/mysql/connect.php');
include('../admin/mysql/function.php');
include('../admin/mysql/scrolls.php');
$x = new xClass();
$scroll = new scrolls();
session_start();

?>

<!DOCTYPE html>
<html lang="en">
	<?php include('../inc_/head.php') ?>
<body>
	<?php include('../inc_/menu.php') ?>
	
	
	<div class="library-contaienr">
	
		<div class="library-view">
			
			<div class="div-4">
					
					<div class="chooseBox clearfix">
						<div class="checkbox">
							<ul class="left typeIcons">
							  <li>
							  	<input id="scroll-search" type="text" name="search" value="" placeholder="Search..." class="textbox" />
							  </li>
							  <li>
							      <input id="order_checkbox" data-for="order" checked type="checkbox" name="type_order" value="order">
							      <label class="checkbox" for="order_checkbox"><i class="icon-order big"></i></label> 
							      
							  </li>
							  <li>  
							      <input id="energy_checkbox" data-for="energy" checked type="checkbox"  name="type_energy" value="energy">
							      <label class="checkbox" for="energy_checkbox"><i class="icon-energy big"></i></label> 
							     
							  </li>
							  <li>
							      <input id="growth_checkbox" data-for="growth" checked type="checkbox"  name="type_growth" value="grwoth">
							      <label class="checkbox" for="growth_checkbox"><i class="icon-growth big"></i></label> 
							  </li>
							 <li class="">
							     <input id="decay_checkbox" data-for="decay" checked type="checkbox" name="type_decay" value="decay">
							     <label class="checkbox" class="" for="decay_checkbox"><i class="icon-decay big"></i></label> 
							 </li>
							</ul>
						</div>
					</div>
			</div>
				<div class="div-4">
					<?php 
					$query = $db->prepare("SELECT * FROM scrollsCard ORDER BY costgrowth, costorder, costEnergy, costdecay, name");
					
					if ($query->execute()) {
					
					while ($scroll = $query->fetch(PDO::FETCH_ASSOC)) { 
					if (!empty($scroll['costorder'])) {
					
						$scrollType = "order";
					} elseif (!empty($scroll['costgrowth'])) {
					
						$scrollType = "growth";
					} elseif (!empty($scroll['costenergy'])) {
					
						$scrollType = "energy";
					} elseif (!empty($scroll['costdecay'])) {
				
						$scrollType = "decay";		
					}
					
					?>
							
					<div class="image-holder"
						 data-id="<?php echo($scroll['id']) ?>">
						 
						 <span class="hidden" id="scroll-name"><?php echo(strtolower($scroll['name'])) ?></span>
						 <span class="hidden" id="scroll-faction"><?php echo($scrollType) ?></span>
						<p class="visible-desktop"><?php echo($scroll['name']) ?></p>
						<img src="../resources/cardImages/<?php echo($scroll['image']) ?>.png" alt="" />
					</div>
							
					<?php } 
						} ?>
				</div>
		</div>
		<div class="library-info">
			<div class="div-4">
				<div class="span-4">
					<div class="div-4">
						<h3 class="color-white">Related Scrolls</h3>
						<div class="image-holder" data-id="1">
							<p class="visible-desktop">Scroll Name</p>
							<img src="../resources/cardImages/479.png" alt="" />
						</div>
						<div class="image-holder" data-id="1">
							<p class="visible-desktop">Scroll Name</p>
							<img src="../resources/cardImages/480.png" alt="" />
						</div>
						<div class="image-holder" data-id="1">
							<p class="visible-desktop">Scroll Name</p>
							<img src="../resources/cardImages/481.png" alt="" />
						</div>
						<div class="image-holder" data-id="1">
							<p class="visible-desktop">Scroll Name</p>
							<img src="../resources/cardImages/482.png" alt="" />
						</div>
					</div>
					<div class="div-4">
						<h1 class="color-white">Unit Name</h1>
						<p class="">This is the scrolls description</p>
					
					</div>
				</div>
				<div class="span-4">
			
			
				</div>
			</div>
			<div class="div-4">
				<div >
					<img class="left" src="../img/deck_decay.png" alt="" />
					<h3 class="left color-white" style="width: 300px;">[Unit Name] is used in X decks on scrolldier.com</h3>
				</div>
			</div>
		
		</div>
		
	</div>
	
<!-- 	<?php include("../inc_/footer.php"); ?> -->
<script src="../jquery.js"></script>
<script>

	$(function() {
	
		//functions
	
		function hideAll() {
			$("[id*='scroll-name']").parent().hide();
			
		}
	
		function showAll() {
			if ($("#scroll-search").length == 0) {
				$("[id*='scroll-name']:not(.isHidden)").parent().show();
			} else {
				$("[id*='scroll-name']:contains('" + word + "'):not(.isHidden)").parent().hide(); 
			}
		}
		function search() {
			var word = $("#scroll-search").val().toLowerCase();
			hideAll();
			$("[id*='scroll-name']:contains('" + word + "'):not(.isHidden)").parent().show();
			$("[class*='isHidden']").hide();
		}
		
		//Interacton
		
		$("div[class*='image-holder']").click(function() {
			alert($(this).attr("data-id"));
		});
	
		$("[type='checkbox']").change(function() {
			if ($(this).is(":checked")) {
				$("[id*='scroll-faction']:contains('" + $(this).attr("data-for") + "')").parent().show();
				$("[id*='scroll-faction']:contains('" + $(this).attr("data-for") + "')").prev("span").removeClass("isHidden");
			} else {
				$("[id*='scroll-faction']:contains('" + $(this).attr("data-for") + "')").parent().hide();
				$("[id*='scroll-faction']:contains('" + $(this).attr("data-for") + "')").prev("span").addClass("isHidden");
			}
			search();
		});
	
		$("#scroll-search").keyup(function() {
			search();
		});
	
	});

</script>
</body>
</html>