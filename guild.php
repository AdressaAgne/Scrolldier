<?php 
	include('admin/mysql/connect.php');
	include_once('admin/mysql/function.php');
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
	<title>Scrolldier.com</title>
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>

	<?php include('inc_/menu.php') ?>
	<?php 
		
			$query = $db->prepare("SELECT * FROM guild WHERE isHidden = 0 ORDER BY guild_score DESC, time DESC");
			$query->execute();
	 ?>
		<div class="container">
			<div class="decks div-margin">
			<?php if (isset($_SESSION['username']) && $x->hasGuild($_SESSION['username'])) { ?>
				<div class="" style="margin-left: -5px; margin-bottom: 10px; margin-top: 0px;">
					<a class="btn-modern" href="guild/index.php">New Guild</a><br />
				</div>
			<?php } ?>
				<div class="div-4">
					To get a guild score, you need at least 5 members with a badge rank
				</div>
				<table class="div-4">
					<tr class="modern">
						<td width="20px"></td>
						<td width="300px">Name</td>
						<td width="50px">Badge</td>
						<td>Members</td>
						<td>Required Rating</td>
						<td>Score</td>	
						<td>Leader</td>
					</tr>
					<?php while ($deck = $query->fetch(PDO::FETCH_ASSOC)) { ?>
					<?php 
							$guilds = $db->prepare("
								SELECT * FROM guild
								LEFT JOIN guildMembers
								ON  guild.id = guildMembers.guild_id WHERE guildMembers.guild_id = :id ");
								
							$arr = array(
									'id' => $deck['id']
								);
							
							$x->arrayBinderInt($guilds, $arr);	
							$guilds->execute();
							$total = $guilds->rowCount();
					 ?>
					<tr>
						<?php if (!empty($deck['badge_url'])) { ?>
							<td><img width="22px" src="<?php echo($deck['badge_url']) ?>" alt="<?php echo($deck['name']) ?>" /></td>
						<?php } else { ?>
							<td></td>
						<?php } ?>
						<td><a href="guild/<?php echo($deck['id']) ?>"><?php echo($deck['name']) ?></a></td>
						<td><?php echo($deck['short_name']) ?></td>
						<td><?php echo($total) ?></td>
						<td><?php echo($deck['requerd_rating']) ?></td>
						<td><?php echo($deck['guild_score']) ?></td>
						<td><a href="user/<?php echo($deck['guild_leader']) ?>"><?php echo($deck['guild_leader']) ?></a></td>
					</tr>
					
					<?php } ?>
				</table>
			</div>
		</div>
	<?php include("inc_/footer.php"); ?>
</body>
</html>