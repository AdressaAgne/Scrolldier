<?php 
include('../admin/mysql/connect.php');
include('../admin/mysql/function.php');
include('../admin/mysql/scrolls.php');
$x = new xClass();
$scroll = new scrolls();
session_start();

?>


<!-- {"deck":"","author":"Orangee","types":[117,188,42,157,25,166,74,21,75,1,173,187,196,82,123,122,32,200,22,65,58,51,107,186,155,92,175,130,77,81,33,192,116,30,78,160,183,161,62,67,53,193,145,201,50,3,121,146,26,104,138,156,105,179,139,95,163,2,45,64,117,188,42,157,25,166,74,21,75,1,173,187,196,82,123,122,32,200,22,65,58,51,107,186,155,92,175,130,77,81,33,192,116,30,78,160,183,161,62,67,53,193,145,201,50,3,121,146,26,104,138,156,105,179,139,95,163,2,45,64,117,188,42,157,25,166,74,21,75,1,173,187,196,82,123,122,32,200,22,65,58,51,107,186,155,92,175,130,77,81,33,192,116,30,78,160,183,161,62,67,53,193,145,201,50,3,121,146,26,104,138,156,105,179,139,95,163,2,45,64]} -->

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Scrolldier.com</title>
		<link rel="icon" type="image/png" href="<?php echo($main) ?>img/bunny.png">
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
		<link rel="stylesheet" href="<?php echo($main) ?>css/library.css"/>
	</head>
	
<body>
	<?php include('../inc_/menu.php') ?>
	
	
	<div class="library-container clearfix">
			<h3 class="color-white">Complete your scrolls collection</h3>
			<p>Currently only works with 1x of each type</p>
			<p>How do this work?</p>
			<ol class="indent">
				<li>Go to your deckbuilder</li>
				<li>Don't search for anything to see everything you got 0 of, Search #:3+ to see everything you need to get a full playset</li>
				<li>Hit the "Add Scrolls" button</li>
				<li>Click "Save Deck", then press Export <i class="icon-export"></i></li>
				<li>Copy the String you get to the field below</li>
				<li>Click the "Find my missing scrolls" button</li>
			</ol>
			<br />
			<p><b>Note:</b> To find the scrolls you are missing that you already have 1+.</p>
				<ol class="indent">
					<li>Go to your deckbuilder</li>
					<li>Search: #:2-</li>
					<li>now all the scrolls you have 2 or less of should show up.</li>
				</ol>
			<br />
			<p><b>Crafting tip:</b></p>
				<ol class="indent">
					<li>Go to your deckbuilder</li>
					<li>Search: #:5+ l:1</li>
					<li>now it only shows tier 1 scrolls you have 5 or more of, now you can craft without thinking of ending up with only 2 tier 2. you will always have 3+ of the same scrolls this way. Now Just hold drag in to the crafting table</li>
				</ol>
		<div class="library-view">
				
			<div class="div-4">
				<label for="missingString">Paste you in-game export string here</label>
			</div>
			<textarea id="missingString" class="textbox div-4" rows="5" placeholder="In-game export link"></textarea>
			<div class="div-4">
				<button id="missingSubmit" class="btn-modern btn-no-margin">Find my missing scrolls</button>
			</div>
			
			<div class="missing div-4">
			
			
			</div>
			
		</div>
		<div class="overlay"></div>
		<div class="outer-library"></div>
	</div>
<script src="../jquery.js"></script>
<script>

	$(function() {
		$(document).on("click", "#missingSubmit", function() {
			var scrolls = $("#missingString").val();
			$.ajax({
			  type: "POST",
			  url: "<?php echo($main) ?>library/missingAjax.php",
			  data: { scroll: scrolls}
			  
			}).done(function(data) {
			    $(".missing").html(data);
			 });
		});
		
		
		$(document).on("click", "div[id^='ScrollsNr'], div[class*='image-holder']", function() {
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
		
		$(document).on("click", "#closeDeck", function() {
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
		
		$(document).on("click", "#show-all-decks", function() {
			var id = $(this).attr("data-id");
			$.ajax({
			  type: "POST",
			  url: "<?php echo($main) ?>inc_/ajax/relatedDeck.php",
			  data: { scroll: id}
			  
			}).done(function(data) {
				$(".outer-library").show();
				$(".overlay").show();
			    $(".outer-library").html(data);
			 });
		});
		
		$(document).on("click", "#close", function() {
			$(".outer-library").hide();
			$(".overlay").hide();
		});
		
		
		$(".outer-library").click(function(e){
		 if(e.target != this) return
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