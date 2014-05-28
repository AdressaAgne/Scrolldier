<?php 
	include('../admin/mysql/connect.php');
	include_once('../admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}
	if (!isset($_SESSION['username'])) {
		header("location: ../login.php");
	}
	//[LIMIT {[offset,] row_count | row_count OFFSET offset}]
	$query = $db->prepare("SELECT * FROM accounts WHERE ign = :ign");	

	$arr = array(
			'ign' => $_SESSION['username']
		);
	$x->arrayBinder($query, $arr);
		
	$query->execute();
	
	$row = $query->fetch(PDO::FETCH_ASSOC);
	
	
	//pw_old, pw_new pw_new2
	if (isset($_POST['editPassword']) && !empty($_POST['editPassword'])) {
	
		if (isset($_POST['pw_old']) && !empty($_POST['pw_old'])) {
			if (isset($_POST['pw_new']) && !empty($_POST['pw_new'])) {
				if (isset($_POST['pw_new2']) && !empty($_POST['pw_new2'])) {
					
					if (sha1($_POST['pw_old']) == $row['password']) {
						
						if ($_POST['pw_new'] === $_POST['pw_new2']) {
							
							
							if ($x->changePassword($_POST['pw_new'], $row['id'])) {
								$_GET['success'] = "Password Chanegd";
							}
							
						} else {
							$_GET['info'] = "Both new Password need to match";
						}
						
					} else {
						$_GET['info'] = "Your old password are incorrect";
					}
					
				} else {
					$_GET['info'] = "Write the new Password again";
				}
			} else {
				$_GET['info'] = "Write a new Password";
			}
		} else {
			$_GET['info'] = "Write your old Password";
		}
	
	}
	
	if (isset($_POST['changeHead']) && !empty($_POST['changeHead'])) {
		if ($x->updatePlayerHead($row['ign'])) {
			$_GET['success'] = "Head successfully updated, too see your new head please relog";
		}
	}
	
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolldier.com - Settings</title>
	<link rel="icon" type="image/png" href="../img/bunny.png">
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
					<img src="../resources/head_<?php echo($row['headID']) ?>.png" width="300px" style="margin-left: -50px; margin-top: -20px;" alt="" />
				</div>
				<form method="post" action="">
					<input type="hidden" name="changeHead" value="changeHead" />
					<input type="submit" class="btn" name="" value="Update Avatar" />
				</form>
			</div>
			<div class="div-second scrolls clearfix">
				<h1>Settings</h1>
				<!--<form method="post" action="">
					<div class="div-3 settings-element">
						<h4>General Settings</h4>
						<div class="div-3">
							<label for="ign">In Game Name</label><br />
							<input type="text" class="textbox full div-1" disabled name="ign" id="ign" value="<?php echo($row['ign']) ?>" placeholder="In Game Name" />
						</div>
						<div class="div-3">
							<label for="mail">Mail</label><br />
							<input type="email" class="textbox full div-1" name="mail" id="mail" value="<?php echo($row['mail']) ?>" placeholder="Mail" />
						</div>
					</div>
					<div class="div-3 chooseBox left clear settings-element clearfix">
						<div class="div-3">
							<div class="checkbox">
								<ul class="">
								  <li class="div-2">
								      <input id="twitch" type="checkbox" checked="checked" name="" value="">
								      <label class="checkbox" for="twitch"><i class="icon-twitch"></i> Twitch</label> 
								      <input type="text" class="textbox full url" name="" value="" placeholder="Twtich url" />
								  </li>
								  <li class="div-2">  
								      <input id="youtube" type="checkbox" checked="checked" name="" value="">
								      <label class="checkbox" for="youtube"><i class="icon-youtube"></i> Youtube</label> 
								       <input type="text" class="textbox full url" name="" value="" placeholder="Youtube url" />
								     
								  </li>
								</ul>
							</div>
						</div>
					</div>
					<div class="div-3 settings-element">
						<div class="div-3">
							<input type="submit" name="generalSave" class="btn" value="Save" />
						</div>
					</div>
				</form>-->
				<form method="post" action="">
					<div class="div-3 settings-element">
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
						<h4>Change Password</h4>
						
					<!--	Password 	-->	
						<div class="div-3">
							<label for="pw_old">Old Password</label><br />
							<input type="password" class="textbox full div-1" id="pw_old" name="pw_old" value="" placeholder="Old Password"/>
						</div>
						<div class="div-3">
							<label for="pw_new">New Password</label><br />
							<input type="password" class="textbox full div-1" id="pw_new" name="pw_new" value="" placeholder="New Password"/><br />
						</div>
						<div class="div-3">
							<label for="pw_new2">New Password Again</label><br />
							<input type="password" class="textbox full div-1" id="pw_new2" name="pw_new2" value="" placeholder="New Password again"/>
						</div>
					</div>
					<div class="div-3 settings-element">
						<div class="div-3">
							<input type="hidden" name="editPassword" value="editPassword" />
							<input type="submit" name="changeSave" class="btn" value="Change Password" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php include("../inc_/footer.php"); ?>
</body>
</html>