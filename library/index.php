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
		<div class="overlay"></div>
		
		<div class="outer-library"></div>
	</div>
	
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
		
		$(document).on("click", "div[class*='image-holder']", function() {
			var id = $(this).attr("data-id");
			$.ajax({
			  type: "POST",
			  url: "<?php echo($main) ?>inc_/ajax/scrollLibrary.php",
			  data: { scroll: id}
			  
			}).done(function(data) {
				$(".outer-library").show();
				$(".overlay").show();
			    $(".outer-library").html(data);
			 });
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
		
		$(document).on("click", "#close", function() {
			$(".outer-library").hide();
			$(".overlay").hide();
		});
		
		$(".overlay").click(function() {
			$(".outer-library").hide();
			$(".overlay").hide();
		});
	
	});

</script>
</body>
</html>