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
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
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
 			<h3 class="align-center">Import from: <i class="icon-import"></i></h3>
 			<a href="<?php echo($main) ?>new/import/scrollguide" class="div-half btn-modern align-center btn-choose"> 
 				<i class="icon-sg"></i>
 				</a>
 			<a href="<?php echo($main) ?>new/import/in-game/" class="div-half btn-modern align-center btn-choose">
 				<i class="icon-scrollsLogo"></i>
 			</a>
 			<a href="<?php echo($main) ?>deckbuilder/" class="btn-modern div-full-choose align-center btn-choose">Build New Deck<br /><small>Scrolldier deckbuilder</small></a>
 		</div>
 	</div>
 <?php include("inc_/footer.php"); ?>
</body>
</html>