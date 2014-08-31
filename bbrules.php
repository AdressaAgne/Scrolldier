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

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>THE BRAGGIN' BRAWL Rules</title>
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
 			<div class="div-4 align-center">
 				<img src="http://i1247.photobucket.com/albums/gg634/davidslain/guild_cup_transparent.png" width="300px" alt="" />
 				<h1>THE BRAGGIN' BRAWL Rules</h1>
 			</div>
 			<div class="div-4 context">
 				
 				<h3>Itro</h3>
				
 				<p>THE BRAGGIN' BRAWL is a Scrolls guild tournament held on the first saturday of each month, where teams compete to get a Trophy. The Final Guilds battle is held 1 week after the other battles. <p>

 				
 				<h3>Joining as a guild:</h3>
 					<p>To join the battle you need a guild with 5 or more players<span class="color-red">*</span></p>
 					<p>You can only join the 2nd Braggin Brawl after the guilds creation</p>
 					<p>Players participating need to have existed in the participating guild for at least 1 week before THE BRAGGIN' BRAWL starts</p>
 				
 				
 				<h3>Playing the first rounds</h3>
 					<p>Each Guild select 5 players to play, they will be arranged with 1 other player from the opponent guild. 
 				In this list there are now 10 players 5 on each side, 1v1. Now the players are going to play BO3, which each game won grants the guild 1 point.  so it can be 0-2 or 1-2.</p>
 				
 				<p>The winner of the last Braggin Brawl can not compete in the first round</p>
 				
 				
 				
 				<h3>Playing the second round</h3>
 					<p>After all points have bean counted.
 					If there are 2 guilds with equal score they will play against each other with the same rules as round one.</p>
 				
 					<b>Finals.<b>
 					<p>The finals are a King Of The Hill matches.
 					That means each Guild have 5 or less players. A max of 5 players on each side.
 					Each Guild Choose a player to go first, they 2 player against each other, the winning guild of that match will still have the winning player in the tournament, the loosing team will loos that player. </p>
 				
 					<p>The winning player will always play again with a new player chosen from the other guild. Until one guild run out of participants.</p>
 				
 					<b>The guild in the finals. </b>
 					<p>Winner of Round 1 VS. Winner of the Last Braggin brawl.</p>
 				
 					<p>If the last winner don’t have 5 people they can NOT have players from other teams play for them. They need to play with say f.ex 3 player if they only have 3 players who can play. So we get a 5 Vs 3 match. If this should happen 1 player will get 1 extra life</p>
 					
 					<p>The winning Guild of THE BRAGGIN' BRAWL has the right to display the trophy (known as “Susan”) on their guild page or in scrollsguide signatures, and if they lose they must immediately remove the trophy from their guild page and scrollsguide signatures.
 					</p>
 				
 				<h3>Judging winners</h3>
 					<p>Each win in round 1 should be taken a screen shot of the "Winner»  screen to prove that you actually won, in the case of an objection from the other guilds member. </p>
 				
 					<p>All guilds members have to show up on time else Disqualified. This means no more then 10min late to a match.</p>
 				
 					<p>Its not allowed of other guilds guild members to take the place for a player, or player with no guild</p>
 				
 				
 				<h3>Deck Rules</h3>
 					<p>You are allowed to play every single deck in the game as long as its a legal deck (50+ scrolls).
 					Any player can change the deck between matches.</p>
 				
 				
 				<h3>Other rules<span class="color-red">*</span></h3>
 					<p>Total players in the tournament can be changed if all guilds that will participate agrees to do so.<p>
 					<p>You can have 5 players or 3 players.</p>
 					<p>Rules can not be changed on the day of the Tournament or the day before.</p>
 					
 				
 			</div>
 		</div>
 	</div>
 	<?php include("inc_/footer.php"); ?>
</body>
</html>