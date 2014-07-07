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
	
	if (isset($_POST['generalSave'])) {
		$query = $db->prepare("UPDATE accounts SET twitch=:twitch, youtube=:youtube, feed_twitch=:fth, feed_twitter=:ftr, feed_match_history=:fmh WHERE ign=:ign");
		
		if (!isset($_POST['twitch'])) {
			$_POST['twitch'] = "";
		} else {
			$_POST['twitch'] = str_replace("http://", "", $_POST['twitch']);
			$_POST['twitch'] = str_replace("https://", "", $_POST['twitch']);
			$_POST['twitch'] = str_replace("www.twitch.tv/", "", $_POST['twitch']);
			$_POST['twitch'] = str_replace("twitch.tv/", "", $_POST['twitch']);
		}
		if (!isset($_POST['youtube'])) {
			$_POST['youtube'] = "";
		} else {
			$_POST['youtube'] = str_replace("http://", "", $_POST['youtube']);
			$_POST['youtube'] = str_replace("https://", "", $_POST['youtube']);
			$_POST['youtube'] = str_replace("www.youtube.com/user/", "", $_POST['youtube']);
			$_POST['youtube'] = str_replace("youtube.com/user/", "", $_POST['youtube']);
			$_POST['youtube'] = str_replace("www.youtube.com/", "", $_POST['youtube']);
			$_POST['youtube'] = str_replace("youtube.com/", "", $_POST['youtube']);
		}
		
		if (isset($_POST['frontTwitch'])) {
			$frontTwitch = 1;
		} else {
			$frontTwitch = 0;
		}
		
		if (isset($_POST['frontTwitter'])) {
			$frontTwitter = 1;
		} else {
			$frontTwitter = 0;
		}
		if (isset($_POST['profileMatch'])) {
			$profileMatch = 1;
		} else {
			$profileMatch = 0;
		}
		
		$arr = array(
				'ign' => $_SESSION['username'],
				'twitch' => $_POST['twitch'],
				'youtube' => $_POST['youtube'],
				'fth' => $frontTwitch,
				'ftr' => $frontTwitter,
				'fmh' => $profileMatch,
		);
		$x->arrayBinder($query, $arr);
		

		if ($query->execute()) {

			header("location:".$main."edit/user?success=General Settings updated");
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
			
				<div class="wall_small">
					<h1 class="modern">Avatar</h1>
				<div class="avatar">
					<img src="../resources/head_<?php echo($row['headID']) ?>.png" width="300px" style="margin-left: -50px; margin-top: -20px;" alt="" />
				</div>
				<form method="post" action="">
					<input type="hidden" name="changeHead" value="changeHead" />
					<input type="submit" class="btn-modern btn-no-margin" name="" value="Update Avatar" />
				</form>
			</div>
				
				<div class="wall_big">
					
				<h1 class="modern">Settings</h1>
				<form method="post" action="" class="">
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
					<!--<div class="div-3 settings-element">
						<h4>General Settings</h4>
						<div class="div-3">
							<label for="ign">In Game Name</label><br />
							<input type="text" class="textbox full div-1" disabled name="ign" id="ign" value="<?php echo($row['ign']) ?>" placeholder="In Game Name" />
						</div>
						<div class="div-3">
							<label for="mail">Mail</label><br />
							<input type="email" class="textbox full div-1" name="mail" id="mail" value="<?php echo($row['mail']) ?>" placeholder="Mail" />
						</div>
					</div>-->
					<div class="div-3 left clear settings-element clearfix">
						<h4>Social</h4>
						<div class="div-3">
							<div class="span-4">
							      <label class="checkbox" for="twitch"><i class="icon-twitch"></i> Twitch</label> <br />
							      <input type="text" class="textbox div-2" name="twitch" id="twitch" value="<?php echo($row['twitch']) ?>" placeholder="Twtich url" />
							</div>
							<div class="span-4">   
							      <label class="checkbox" for="youtube"><i class="icon-youtube"></i> Youtube</label> <br />
							       <input type="text" class="textbox div-2" name="youtube" id="youtube" value="<?php echo($row['youtube']) ?>" placeholder="Youtube url" />
							</div>
						</div>
					</div>
					<div class="div-3 settings-element">
						<h4>Frontpage  (does nothing yet)</h4>
						<div class="div-3">
							<input type="checkbox" class="normal_checkbox" name="frontTwitch" id="frontTwitch" <?php if ($row['feed_twitch'] == 1) { echo("checked"); } ?> value="" />
							<label for="frontTwitch" class="normal_checkbox"></label>
							<label for="frontTwitch" class="hand">Show Twitch stream's on front page</label>
						</div>
						<div class="div-3">
							<input type="checkbox" class="normal_checkbox" name="frontTwitter" id="frontTwitter" <?php if ($row['feed_twitter'] == 1) { echo("checked"); } ?> value="" />
							<label for="frontTwitter" class="normal_checkbox"></label>
							<label for="frontTwitter" class="hand">Show Dev's Twitter feed on front page</label>
						</div>
						<h4>Profile</h4>
						<div class="div-3">
							<input type="checkbox" class="normal_checkbox" name="profileMatch" id="profileMatch" <?php if ($row['feed_match_history'] == 1) { echo("checked"); } ?> value="" />
							<label for="profileMatch" class="normal_checkbox"></label>
							<label for="profileMatch" class="hand">View my match history to other players</label>
						</div>
					</div>
					<div class="div-3 settings-element">
						<div class="div-3">
							<input type="submit" name="generalSave" class="btn-modern btn-no-margin" value="Save" />
						</div>
					</div>
				</form>
				<form method="post" action="">
					<div class="div-3 settings-element">
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
							<input type="submit" name="changeSave" class="btn-modern btn-no-margin" value="Change Password" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php include("../inc_/footer.php"); ?>
</body>
</html>