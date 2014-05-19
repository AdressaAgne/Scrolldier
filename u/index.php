<?php 
	include('../admin/mysql/connect.php');
	include_once('../admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}
	if (!isset($_SESSION['username'])) {
		$actual_link = $_SERVER['REQUEST_URI'];
		header("location: ../login.php?re=".$actual_link);
	}
	
	
	
		if (empty($_GET['u'])) {
			$_GET['u'] = $_SESSION['username'];
		}
		
		
		$query = $db->prepare("SELECT * FROM accounts WHERE ign=:user");	
	
		$arr = array(
				'user' => $_GET['u']
			);
			

		$x->arrayBinder($query, $arr);
			
		$query->execute();
		
		$user = $query->fetch(PDO::FETCH_ASSOC);
		
		
if (isset($_POST['submitInvite'])) {
	$guildQu = $db->prepare("INSERT INTO notification (user_id, type, text, guild_id) VALUES (:name, 1, :text, :guild)");
	$arr = array(
			'name' => $_POST['name'],
			'text' => "You have been invited to join " . $_POST['gname'],
			'guild' => $_POST['gid']
		);
		
	$x->arrayBinder($guildQu, $arr);
	if ($guildQu->execute()) {
		$_GET['success'] = "User invited to your guild";
	}
}
		
		
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo($user['ign']) ?> - Scrolldier.com</title>
	<link rel="icon" type="image/png" href="<?php echo($main) ?>img/bunny.png">	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
</head>
<body>
	<?php include('../inc_/menu.php') ?>
	<div class="body" id="blog">
		<div class="container">
			<div class="scrolls div-first">
				<div class="avatar">
					<img src="<?php echo($main) ?>resources/head_<?php echo($user['headID']) ?>.png" width="300px" style="margin-left: -50px; margin-top: -20px;" alt="" />
				</div>
			</div>
			<?php $userGuild = $x->getGuild($user['ign']) ?>
			
			<div class="div-second scrolls clearfix">
				<?php if (isset($_GET['info'])) { ?>
					<p class="color-red"><?php echo($_GET['info']) ?></p>
				<?php } ?>
				<?php if (isset($_GET['success'])) { ?>
					<p class="color-green"><?php echo($_GET['success']) ?></p>
				<?php } ?>
				<h3><?php echo($user['ign']) ?>'s profile 
				<?php if (!$x->hasGuild($user['ign'])) { ?>
					<img src="<?php echo($userGuild['badge_url']) ?>" alt="" />
				<?php } ?>
				<?php if (strtolower($_GET['u']) == strtolower($_SESSION['username'])) { ?>
					<small class="right modern btn-pagina"><a href="<?php echo($main) ?>edit">Edit Profile</a></small>
				<?php } ?>
				
				<?php if (isset($guild) && $guild['guild_leader'] == $_SESSION['username'] && $x->hasGuild($user['ign'])) { ?>
					<form method="post" action="">
						<small>
							<input type="hidden" name="name" value="<?php echo($user['ign']) ?>" />
							<input type="hidden" name="gid" value="<?php echo($x->getGuildID($_SESSION['username'])) ?>" />
							<input type="hidden" name="gname" value="<?php echo($guild['name']) ?>" />
							<input type="submit" name="submitInvite" class="modern btn-modern btn-pagina" value="Invite to <?php echo($guild['short_name']) ?>" />
						</small>
					</form>
				<?php } ?>
				
				
				
				
				</h3>
				<div class="div-3 settings-element">
					<h4>Stats</h4>
					Comments: <?php echo($x->totalUserComments($_GET['u'])) ?><br />
					Deck votes: <?php echo($x->totalDeckVote($_GET['u'])) ?>
					
					
				 	<?php if (!$x->hasGuild($user['ign'])) { ?><br />
				 	Guild: <a href="../guild/g.php?g=<?php echo( $x->getGuildID2($user['ign']) ) ?>"><?php echo($userGuild['name']) ?></a>
				 	<?php } ?>
					
				</div>
				<div class="div-3 settings-element">
					<h4>Decks by <?php echo($user['ign']) ?></h4>
					<div class="decks div-margin">	
				<table  style="width: 480px !important;">
					<?php
					$query = $db->prepare("SELECT * FROM decks WHERE deck_author=:id AND isHidden = 0 ORDER BY vote DESC, time DESC");
					$arr = array(
							'id' => $user['ign']
						);
					
					$x->arrayBinder($query, $arr);
					$query->execute();		
					while ($deck = $query->fetch(PDO::FETCH_ASSOC)) {
					?>
						<tr>
							<td><a href="<?php echo($main) ?>deck/<?php echo($deck['id']) ?>"><?php echo($deck['deck_title']) ?></a></td>	
							<td>
								<?php if ($deck['growth'] == 1) {
									echo('<i class="icon-growth"></i>');
								}
								
								if ($deck['decay'] == 1) {
									echo('<i class="icon-decay"></i>');
								}
								
								if ($deck['tOrder'] == 1) {
									echo('<i class="icon-order"></i>');
								}
								
								if ($deck['energy'] == 1) {
									echo('<i class="icon-energy"></i>');
								}
								
								if ($deck['wild'] == 1) {
									echo('<i class="icon-wild"></i>');
								}
								 ?>
							</td>
							<td><?php echo($deck['vote']) ?></td>
						</tr>
					<?php } ?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include("../inc_/footer.php"); ?>
</body>
</html>