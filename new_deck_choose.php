<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
$x = new xClass();

session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}
if (!isset($_SESSION['username'])) {
	header("location: ".$main."login.php");
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolls - New Deck</title>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="<?php echo($main) ?>jquery.js"></script>	 
	<script src="<?php echo($main) ?>plugins/ckeditor/ckeditor.js"></script>	
</head>
<body style="padding-bottom: 0px;">
	<?php include('inc_/menu.php'); ?>
	 
 	<div class="container">
 		<div class="div-3 div-center">
 			<h3 class="align-center">Import from:</h3>
 			<a href="<?php echo($main) ?>new/import/scrollguide" class="div-half btn-modern align-center btn-choose">Scrollsguide<br /><small>SG Deckbuilder</small></a>
 			<a href="<?php echo($main) ?>new/import/in-game" class="div-half btn-modern align-center btn-choose">In-Game<br /><small>Available soon</small></a>
 		</div>
 	</div>
 <?php include("inc_/footer.php"); ?>
</body>
</html>