<?php 
	include('../admin/mysql/connect.php');
	include_once('../admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}

	$isGuildLeader = $x->isGuildLeader($_SESSION['username']);
	if (!$x->canInviteToGuild2($_SESSION['username']) && $isGuildLeader == false) {
		header("location: ../guild.php");
	}
	
	$query = $db->prepare("SELECT * FROM guild WHERE id = :id");
		
	$arr = array(
			'id' => $x->getGuildID2($_SESSION['username'])
		);
	
	$x->arrayBinder($query, $arr);	
	$query->execute();
	$g = $query->fetch(PDO::FETCH_ASSOC);


	if (isset($_POST['submitInvite'])) {
			$guildQu = $db->prepare("INSERT INTO notification (user_id, type, text, guild_id) VALUES (:name, 1, :text, :guild)");
			$arr = array(
					'name' => $_POST['player'],
					'text' => "You have been invited to join " . $g['name'],
					'guild' => $g['id']
				);
				
			$x->arrayBinder($guildQu, $arr);
			if ($guildQu->execute()) {
				$_GET['success'] = $_POST['player']." are now invited to ".$g['name'];
			}
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolldier.com</title>
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
	
	<script src="../jquery.js"></script>	 
	<script src="../plugins/ckeditor/ckeditor.js"></script>	
</head>
<body>

	<?php include('../inc_/menu.php') ?>
		<div class="container">
			<div class="div-3">
				<h1>Invite Players to <?php echo($g['name']) ?></h1>
<!--				<p class="color-red">Datalist does not work in Safari</p>-->
					<?php if (isset($_GET['success'])) {
						echo("<p class='color-green'>".$_GET['success']."</p>");
					} ?>
				<form method="post" action="">
					<div class="div-3">
						<input list="player" name="player" class="textbox full div-1" placeholder="Search player">
						<datalist id="player">
						<?php 
							$query = $db->prepare("SELECT ign FROM accounts");
							$query->execute();
	
							while ($player = $query->fetch(PDO::FETCH_ASSOC)) {
							echo("<option value='".$player['ign']."'>");
								
							 } ?>
						</datalist>
					</div>
					<div class="div-3">
						<input type="submit" name="submitInvite" value="Invite" class="btn" />
					</div>
				</form>
			</div>
			<div class="div-3">
				<h2>Already Invited Players</h2>
				<?php 
				$query = $db->prepare("SELECT * FROM notification WHERE type = 1 AND guild_id=:gid");
				$arr = array(
						'gid' => $g['id']
					);
					
				$x->arrayBinder($query, $arr);
				$query->execute();

				while ($player = $query->fetch(PDO::FETCH_ASSOC)) { ?>
				
				<p><a href="http://scrolldier.com/u/?u=<?php echo($player['user_id']) ?>" target="_blank"><?php echo($player['user_id']) ?></a></p>
					
				<?php } ?>
			</div>
		
		
		</div>
	<?php include("../inc_/footer.php"); ?>
</body>
</html>