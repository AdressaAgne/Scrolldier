<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
$x = new xClass();

session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolls - Scrolldier Badges</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="icon" type="image/png" href="img/bunny.png">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="jquery.js"></script>	 
	<script src="plugins/ckeditor/ckeditor.js"></script>	
</head>
<body style="padding-bottom: 0px;">
	<?php include('inc_/menu.php'); ?>
 	<div class="container clearfix">
 		<div class="div-4">
 			<div class="div-4">
 			<h2>Badges on Scrolldier:</h2>
 			</div>
 			<div class="div-4">
 			<ul class="badge-icon left">
 				<li><i class='icon-ig-mojang'></i><ul><li class='modern'>Mojangster</li></ul></li>
 				<li><i class='icon-mod'></i><ul><li class='modern'>Moderator of scrolldier</li></ul></li>
 				<li><i class='icon-ig-mod'></i><ul><li class='modern'>Moderator in-game</li></ul></li>
 				<li><i class='icon-beetle'></i><ul><li class='modern'>Whit-listed on the Beetlestone Society Minecraft Server</li></ul></li>
 				<li><i class='icon-admin'></i><ul><li class='modern'>Admin of scrolldier</li></ul></li>
 				<li><i class='icon-donor'></i><ul><li class='modern'>Have donated to Scrolldier.com</li></ul></li>
 				<li><i class='icon-guild'></i><ul><li class='modern'>Name is a guild leader</li></ul></li>
 				<li><i class='icon-sgAdmin'></i><ul><li class='modern'>ScrollsGuide Admin</li></ul></li>
 				<li><i class='icon-ig-demo'></i><ul><li class='modern'>Scrolls Demo user</li></ul></li>
 				<li><i class='icon-alpha'></i><ul><li class='modern'>Scrolldier Alpha User</li></ul></li>
 				<li><i class='icon-beta'></i><ul><li class='modern'>Scrolldier Beta user</li></ul></li>
 				
 				<li><i class='icon-ban'></i><ul><li class='modern'>Banned from Scrolldier</li></ul></li>
 				
 				
 				<li><i class='icon-crad'></i><ul><li class='modern'>Cradstache</li></ul></li>
 				<li><i class='icon-dota'></i><ul><li class='modern'>Zylus</li></ul></li>
 				<li><i class='icon-icecream'></i><ul><li class='modern'>iScrE4m</li></ul></li>
 				
				<li><i class='icon-matches-2k'></i><ul><li class='modern'>Played over 2000 matches</li></ul></li>
				<li><i class='icon-matches-1k'></i><ul><li class='modern'>Played over 1000 matches</li></ul></li>
				<li><i class='icon-ranked-1k'></i><ul><li class='modern'>Won over 1000 ranked matches</li></ul></li>
				<li><i class='icon-ranked-500'></i><ul><li class='modern'>Won over 500 ranked matches</li></ul></li>
				<li><i class='icon-lost-1k'></i><ul><li class='modern'>Lost over 1000 matches</li></ul></li>
 				
 				
 				<li><i class='icon-1st'></i><ul><li class='modern'>1at place in a tournament</li></ul></li>
 				<li><i class='icon-2nd'></i><ul><li class='modern'>2nd place in a tournament</li></ul></li>
 				<li><i class='icon-3rd'></i><ul><li class='modern'>3rd place in a tournament</li></ul></li>
 				
 				<li><i class='icon-win-1st'></i><ul><li class='modern'>Weekly winner 1st</li></ul></li>
 				<li><i class='icon-win-most'></i><ul><li class='modern'>Weekly winner Most Wins</li></ul></li>
 				<li><i class='icon-win-2nd'></i><ul><li class='modern'>Weekly winner 2nd</li></ul></li>
 				<li><i class='icon-win-3rd'></i><ul><li class='modern'>Weekly winner 3rd</li></ul></li>
 				
 				
 				
 			
 			</ul>
 			</div>
 		</div>
 	</div>
 	<?php include("inc_/footer.php"); ?>
</body>
</html>