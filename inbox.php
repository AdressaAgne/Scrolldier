<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
$x = new xClass();

session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}
if (!isset($_SESSION['username'])) {
	header("location: login.php");
}


if (isset($_POST['submitJoin'])) {
	
	if ($x->hasGuild($_SESSION['username'])) {
		
		if ($x->addGuildMember($_SESSION['username'], $_POST['gid'], false)) {
			$_GET['success'] = "You joined a Guild!";
			
		}
		
	} else {
		$_GET['info'] = "You cant join this guild, you are already a member of an other.";
	}
	
}
if (isset($_POST['submitDecline'])) {
	
	if ($x->delGuildInvite($_POST['id'])) {
		$_GET['succes'] = "Daclined Invitation";
	} else {
		$_GET['info'] = "Error";
	}
}

$x->setReadMessage($_SESSION['username'],2);

if (isset($_POST['submitDeleteMessage'])) {
	$x->delGuildInvite($_POST['msgID']);
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolls - Notifications</title>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
	<link rel="icon" type="image/png" href="<?php echo($main) ?>img/bunny.png">
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
 		<?php if (isset($_GET['info']) && !empty($_GET['info'])) { ?>
 			<div class="div-3">
 				<p class="color-red"><?php echo($_GET['info']) ?></p>
 			</div>
 		<?php } ?>
 		<?php if (isset($_GET['success']) && !empty($_GET['success'])) { ?>
 			<div class="div-3">
 				<p class="color-green"><?php echo($_GET['success']) ?></p>
 			</div>
 		<?php } ?>
 		<div class="div-4">
			<a href="<?php echo($main."inbox/message/") ?>" class="btn-modern btn-no-margin">Send a Private message</a>
 		</div>
 		<div class="decks">
			<table>
				<tr class="modern">
					<td>Notifications</td>
					<td width="250px"></td>
					<td width="140px"></td>
					<td width="40px"></td>
				</tr>
				
				
				<?php 
				$query = $db->prepare("SELECT * FROM notification WHERE user_id=:ign");
				$arr = array(
						'ign' => $_SESSION['username']
					);
				$x->arrayBinder($query, $arr);
				$query->execute();
				
				?>
				
				<?php if ($query->rowCount() == 0) { ?>
					<tr>
						<td>Empty</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				<?php } ?>
				
				<?php while ($info = $query->fetch(PDO::FETCH_ASSOC)) { ?>
				
<!--	If type = 1 then print out, type 1 = Guild invite	-->
					<?php if ($info['type'] == 1) { ?>
					<tr>
						<td><a href="guild/g.php?g=<?php echo($info['guild_id']) ?>"><?php echo($info['text']) ?></a></td>
						<td>
							<?php if ($x->hasGuild($_SESSION['username'])) { ?>
							<div class="left">
								<form method="post" action="">
									<input type="hidden" name="gid" value="<?php echo($info['guild_id']) ?>" />
									<input type="hidden" name="id" value="<?php echo($info['id']) ?>" />
									<input type="submit" name="submitJoin" value="Join" class="btn-modern" />
								</form>
							</div>	
							<div class="left">
								<form method="post" action="">
									<input type="hidden" name="gid" value="<?php echo($info['guild_id']) ?>" />
									<input type="hidden" name="id" value="<?php echo($info['id']) ?>" />
									<input type="submit" name="submitDecline" value="Decline" class="btn-modern" />
								</form>
							</div>
							
							<?php } else { ?>
								You already are in a guild!
								<div class="left">
									<form method="post" action="">
										<input type="hidden" name="gid" value="<?php echo($info['guild_id']) ?>" />
										<input type="hidden" name="id" value="<?php echo($info['id']) ?>" />
										<input type="submit" name="submitDecline" value="Decline" class="btn-modern" />
									</form>
								</div>
							<?php } ?>
						</td>
						<td><?php echo($x->ago($info['time'])) ?></td>
						<td><?php if ($info['haveRed'] == 0) {
							echo('<i class="icon-round"></i>');
						} ?></td>
					</tr>
					<? } ?>
<!--	If type = 2 then print out, type 2 = Private Message	-->					
					<?php if ($info['type'] == 2) { ?>
					<tr>
						<td><?php echo($info['text']) ?></td>
						<td>
							<a href="<?php echo($main."inbox/message/".$info['from_user']) ?>">Reply</a>
							PM from <?php echo($info['from_user']) ?>
						</td>
						<td><?php echo($x->ago($info['time'])) ?> ago</td>
						<td><?php if ($info['haveRed'] == 0) {
							echo('<i class="icon-round"></i>');
						} ?>
						<form method="post" action="">
							<input type="submit" name="submitDeleteMessage" class="btn-modern btn-no-margin" value="Delete" />
							<input type="hidden" name="msgID" value="<?php echo($info['id']) ?>" />
						</form>
						</td>
					</tr>
					<? } ?>
					
					
					
				<?php } ?>
			</table>
 		</div>
 	</div>
 	<?php include("inc_/footer.php"); ?>
</body>
</html>