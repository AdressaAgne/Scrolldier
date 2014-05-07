<?php 
	include('../admin/mysql/connect.php');
	include_once('../admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}
	$isGuildLeader = $x->isGuildLeader($_SESSION['username']);
	if (isset($_POST['leaveGuild'])) {
		if ($isGuildLeader == true) {
			$_GET['info'] = "You can not leave a guild you are leader of, please set a new guild leader then you can leave.";
		} else {
			$query = $db->prepare("DELETE FROM guildMembers where user_id = :user_id");
			$arr = array(
					'user_id' => $_SESSION['username']
				);
			
			$x->arrayBinder($query, $arr);
			$query->execute();
		}	
	}
		$query = $db->prepare("
			SELECT * FROM guild
			LEFT JOIN guildMembers
			ON  guild.id = guildMembers.guild_id WHERE guildMembers.guild_id = :id ");
			
		$arr = array(
				'id' => $_GET['g']
			);
		
		$x->arrayBinderInt($query, $arr);	
		$query->execute();
		
	$query2 = $db->prepare("
		SELECT * FROM guild
		LEFT JOIN guildMembers
		ON  guild.id = guildMembers.guild_id WHERE guildMembers.guild_id = :id ");
		
	$arr2 = array(
			'id' => $_GET['g']
		);
	
	$x->arrayBinderInt($query2, $arr2);	
	$query2->execute();
	$g = $query2->fetch(PDO::FETCH_ASSOC);
	
	$query3 = $db->prepare("
		SELECT * FROM guild WHERE id = :id ");
		
	$arr3 = array(
			'id' => $_GET['g']
		);
	
	$x->arrayBinderInt($query3, $arr3);	
	$query3->execute();
	$lookingatguild = $query3->fetch(PDO::FETCH_ASSOC);
	
	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo($g['name']) ?> - Scrolldier.com</title>
	
	<?php if (empty($g['badge_url'])) { ?>
		<link rel="icon" type="image/png" href="../img/bunny.png">
	<?php } else { ?>
		<link rel="icon" type="image/png" href="<?php echo($g['badge_url']) ?>">
	<?php } ?>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="../css/style.css" />
</head>
<body>

	<?php include('../inc_/menu.php') ?>
		<div class="container">
				<h1><?php echo($g['name']) ?> (<?php echo($query2->rowCount()) ?>)
				<?php if ($x->canEditGuild($_SESSION['username'], $lookingatguild['id'], $lookingatguild['guild_leader'])) { ?>
						<small>
							<form method="post" class="right" action="">
								<input type="button" onclick="location.href='edit.php'" name="leaveGuild"  class="btn-modern" value="Edit Guild" />
							</form>
							
						</small>
				<?php } ?>
				

				<?php if ($x->canInviteToGuild($_SESSION['username'], $lookingatguild['id'], $lookingatguild['guild_leader'])) { ?>
					<small>
						<form method="post" class="right" action="">
							<input type="button" onclick="location.href='invite.php'" name="leaveGuild"  class="btn-modern" value="Invite Players" />
						</form>
					</small>
				<?php } ?>
				<?php if (isset($_SESSION['username']) && $x->getGuildID2($_SESSION['username']) == $lookingatguild['id']) { ?>
						<small>
							<form method="post" class="right" action="">
								<input type="submit" name="leaveGuild" class="btn-modern" value="Leave <?php echo($lookingatguild['name']) ?>" />
							</form>
						</small>
				<?php } ?>
				
				</h1>
				
				<?php if (isset($_GET['info'])) {
					echo("<p class='color-red'>".$_GET['info']."</p>");
				} ?>
				
				<div class="div-4 guild" style="padding: 20px;">
					<p><?php echo($g['desciption']) ?></p>
				</div>
				
				
			<div class="decks div-margin">
				<h1></h1>
				<br />
				<table>
					<tr class="modern">	
						<td width="20px"><img src="<?php echo($g['badge_url']) ?>" width="20px"alt="" /></td>
						<td>Rank</td>
						<td>Guild Members</td>	
					</tr>
					<?php 
					 ?>
					<?php while ($user = $query->fetch(PDO::FETCH_ASSOC)) { ?>
					
					<tr>
						<td></td>
						<td><?php echo($x->getRankName($user['rankID'])) ?></td>
						
						<td><a href="../u/?u=<?php echo($user['user_id']) ?>"><?php echo($user['user_id']) ?></a></td>
					</tr>
					
					<?php } ?>
				</table>
			</div>
		</div>
	<?php include("../inc_/footer.php"); ?>
</body>
</html>