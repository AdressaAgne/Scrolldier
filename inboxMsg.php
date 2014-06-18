<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
$x = new xClass();

session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}
if (!isset($_SESSION['username'])) {
	header("location: login.php?re=inbox/message");
}


if (isset($_POST['submitSend'])) {
	
		$msg = $db->prepare("INSERT INTO notification (user_id, type, text, from_user) VALUES(:toUser, 2, :html, :fromUser)");
	
		
		$msg_arr = array(
				'fromUser' => $_SESSION['username'],
				'toUser' => $_POST['player'],
				'html' => $_POST['html']
			); 
		
		$x->arrayBinder($msg, $msg_arr);
		

	if ($msg->execute()) {
		$_GET['success'] = "Message sent";
		
	} else {
		$_GET['info'] = "There was an error when sending your message";
	}
	
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
		
		<div class="wall_big">
			<form method="post" class="div-4" action="">
				<h3>New Private Message</h3>
				<div class="div-4">
					<label for="player">In game name</label><br />
					<?php include("inc_/form_player.php") ?>
				</div>
				<div class="div-4">
					<label for="editor">Message</label>
					<textarea class="ckeditor" name="html" id="editor"></textarea>
				</div>
				<div class="div-4">
					<input type="submit" name="submitSend" value="Send" class="btn-modern btn-no-margin left" />
				</div>
				
				
				<div class="div-4">
					<p>Note:</p>
					<p>If you send a message to a player who do not got a Scrolldier.com account, the player will get it when he/she sign's up</p>
				</div>
			</form>
		</div>
 	</div>
 	<?php include("inc_/footer.php"); ?>
</body>
</html>