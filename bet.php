<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
include('admin/mysql/badges.php');
$x = new xClass();
$badge = new badges();

session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}
if (!isset($_SESSION['username'])) {
	header("location: login.php");
}
	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolls - Alternative Profile Page</title>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="../jquery.js"></script>	 
	<script src="../plugins/ckeditor/ckeditor.js"></script>	
		
</head>
<body>
	 <?php include('inc_/menu.php'); ?>
	 
	 	
	 
	 <div class="container the-inn-keeper framed">
	 		<div class="div-4 align-center">
	 			<h1>Ugster's Bettin Booth</h1>
	 		</div>
	 </div>
	
	  <div class="container clearfix">
	
			<div class="div-4 align-center framed">
				<div class="div-4 align-center">
					<h1>Total Gold Bet:</h1>
				</div>
				<img src="img/gold_icon.png" width="42px" alt="" style="margin-bottom: -5px;" /><span class="money" style="font-size: 64px;">38425</span>
			</div>
			
			<div class="div-4 align-center framed">
				<div class="span-4">
					<div class="div-4 align-center">
						<h1>Your bet:</h1>
					</div>
					<img src="img/gold_icon.png" width="42px" alt="" style="margin-bottom: -5px;" />
					<span class="money" style="font-size: 64px;">9001</span>
					
				</div>
				
				
				<div class="span-4">
					<div class="div-4 align-center">
						<h1>Current price <small class="color-red">*</small>:</h1>
					</div>
					<img src="img/gold_icon.png" width="42px" alt="" style="margin-bottom: -5px;" /><span class="money" style="font-size: 64px;">19301</span>
					</div>
				</div>
			</div>
			  
		  </div>

	 <div class="container">
			
		<div class="div-4">
			<h2>Place your bet:</h2>
		</div>
		<div class="div-4">
			<form method="post" action="">
				<div class="span-4">
				<label for="guilds">From what guild will the winner be from?</label><br />
				<select id="guilds" name="bet_on">ball	
					<option value="0">Select a guild</option>
					<option value="tbg">TBG</option>
					<option value="as">AS</option>
				</select>
				</div>
				<div class="span-4">
					<label for="gold_bet">How much do you want to bet? (Min: <span class="money"><i class="icon-coin"></i>200g</span>)</label><br />
					<input id="gold_bet" data-input-type="nummeric" type="text" name="gold_bet" class="textbox div-1" value="" min="200" placeholder="1000"/>
				</div>
			</form>
		</div>
			
	 </div>


	<?php include("inc_/footer.php"); ?>
	<script>
		$(function() {
			$("[data-input-type=nummeric]").on("keyup keydown keypress change",function() {
				var value = $(this).val().replace(/\D+/g, "");
				console.log(value);		
				$(this).val(value);
			});
		});
	</script>
</body>
</html