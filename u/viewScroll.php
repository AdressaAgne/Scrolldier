<?php 
	include('../admin/mysql/connect.php');
	include_once('../admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}
 
 	
			
	$fan_query = $db->prepare("SELECT * FROM fanScrolls WHERE link=:link");	
		
	$fan_arr = array(
			'link' => $_GET['image']
		);
		

	$x->arrayBinder($fan_query, $fan_arr);
		
	$fan_query->execute();
	$fanScroll = $fan_query->fetch(PDO::FETCH_ASSOC);		
	
	
	
	if (isset($_POST['delArt']) && $_SESSION['username'] == $fanScroll['user']) {
		
			$query = $db->prepare("DELETE FROM fanScrolls WHERE link=:link");	
				
			$Qarr = array(
					'link' => $_GET['image']
				);
				
		
			$x->arrayBinder($query, $Qarr);
				
			if ($query->execute()) {
				
				if (unlink("user_files/".strtolower($_SESSION['username'])."/".$fanScroll['link'].".png")) {
					header("location: ".$main."user");
				}
			}
		
	}


	if (isset($_POST['name']) && isset($_POST['submit']) && isset($_POST['comment']) && isset($_SESSION['username'])) {
		
		$query = $db->prepare("INSERT INTO comment (byUser, comment, commentToID, headID, cWhere) VALUES (:name, :comment, :commentToID, :headID, 3)");
		$arr = array(
				'name' => $_POST['name'],
				'comment' => $_POST['comment'],
				'commentToID' => $fanScroll['id'],
				'headID' => $_POST['headID']
			);
			
		$x->arrayBinder($query, $arr);		
		if ($query->execute()) {
			if ($fanScroll['user'] != $_SESSION['username']) {
				$x->setNotificationArt($fanScroll['user'], $_POST['name'], $fanScroll['link']);
			}
			
			$hasSent = array();
			array_push($hasSent, strtolower($fanScroll['user']));
			array_push($hasSent, strtolower($_SESSION['username']));
			
			
			$replyQuery = $db->prepare("SELECT byUser FROM comment WHERE commentToID=:id AND cWhere=3");
			$reply_arr = array(
					'id' => $fanScroll['id']
				);
			$x->arrayBinder($replyQuery, $reply_arr);	
			
			
			if ($replyQuery->execute()) {
				while ($reply = $replyQuery->fetch(PDO::FETCH_ASSOC)) {
				
					if (!in_array(strtolower($fanScroll['user']), $hasSent)) {
						array_push($hasSent, strtolower($fanScroll['user']));
						$x->setNotificationReply($fanScroll['user'], $_POST['name'], $main."fanart/".$fanScroll['link'], "scroll");
					}
				}
			}
			
			
		}			
	} 
	
	if (isset($_POST['postID']) && !empty($_POST['postID'])) {
		$x->delComment($_POST['postID'], $_SESSION['username']);
	}
	
	if (isset($_POST['warningUser']) && !empty($_POST['warningUser'])) {
		$x->warnUser($_POST['warningUser']);
		$x->warnPost($_POST['warningPost']);
		
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>FanArt - Scrolldier.com</title>
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
		<div class="wall_small">
		<?php if (isset($_SESSION['username']) && $_SESSION['username'] == $fanScroll['user']) { ?>
		<div class="div-4">
			<form method="post" action="" class="left">
				<input type="submit" class="btn-modern btn-no-margin" name="delArt" value="Delete" />
			</form>
			<form method="post" action="<?php echo($main) ?>scroll/designer" class="left">
				<input type="hidden" name="link" value="<?php echo($fanScroll['link']) ?>" />
				<input type="submit" class="btn-modern btn-no-margin" name="editArt" value="Edit" />
			</form>
		</div>
		<?php } ?>
		
		<?php if ($fan_query->rowCount() != 0) { ?>
			<div class="div-4 div-center clearfix">	
				<p class=" align-center"><?php echo($fanScroll['title']) ?> is made by <a href="<?php echo($main."user/".$fanScroll['user']) ?>"><?php echo($fanScroll['user']) ?></a></p>
				<img src="<?php echo($fanScroll['parma_link']) ?>" class="div-4" alt="" />
			</div>
			<div class="div-4 div-center">
				<label for="paramlink">Direct Image link:</label>
				<input id="paramlink" type="text" readonly="" class="textbox div-4" name="" value="<?php echo($fanScroll['parma_link']) ?>" /><br />
				<label for="linkImage">Image link:</label>
				<input id="linkImage" type="text" readonly="" class="textbox div-4" name="" value="<?php echo($main."fanart/".$fanScroll['link']) ?>" />
			</div>
		<?php } else { ?>
			<div class="span-4 div-center align-center">	
			<p>Art does not exist anymore</p>
		</div>
		<?php } ?>	
		</div>
		<div class="wall_big">
			<?php include("../inc_/comment.php"); ?>
		<div class="containerComment">	
		
		<?php
		$query = $db->prepare("SELECT * FROM comment WHERE commentToID=:id AND cWhere = 3 ORDER BY TIME DESC");
		$arr = array(
				'id' => $fanScroll['id']
			);
		$x->arrayBinder($query, $arr);	
			
		
		
		$query->execute();		
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				
		?>
		
			<div class="avatar scrolls">
				<img src="<?php echo($main) ?>resources/head_<?php echo($row['headID']) ?>.png" alt="" />
			</div>
			<?php $userGuild = $x->getGuild($row['byUser']) ?>
			<div class="commentPost scrolls">
				<h4 class="clearfix">
				<?php if (!$x->hasGuild($row['byUser'])) { ?>
					<div class="left" style="margin-right: 10px;">
							<img src="<?php echo($userGuild['badge_url']) ?>" height="22px" alt="" />
					</div>
				<?php } ?>
				<a class="left" href="<?php echo($main) ?>user/<?php echo(strip_tags($row['byUser'])) ?>">
					<?php echo(strip_tags($row['byUser'])) ?>
				</a>
				<?php if (isset($_SESSION['username']) && $_SESSION['rank'] < 3 || $_SESSION['username'] == $row['byUser']) { ?>
				<small>
				
				<form method="post" class="right" action="">
					<input type="hidden" name="postID" value="<?php echo($row['id']) ?>" />
					<button type="submit" class="btn-modern btn-no-margin" style="padding: 0px;"><i class="icon-trash" style="margin: 3px 3px 1px 3px;"></i></button>
				</form>
				<!--<form method="post" class="right" action="">
					<input type="hidden" name="warningUser" value="<?php echo($row['byUser']) ?>" />
					<input type="hidden" name="warningPost" value="<?php echo($row['id']) ?>" />
					<input type="submit" class="warBtn" name="" value="Warning<?php if ($row['Warning'] >= 1) {
						echo("(".$row['Warning'].")");
					} ?>" />
				</form>-->
				</small>
				<?php } ?>
				
				<?php $thisRank = $x->getUserRank($row['byUser']); ?>
				<?php $thisUser = $row['byUser']; ?>
				<?php include("../inc_/icon_comment.php"); ?>
				
				</h4>
				<div class="comment-text">
					<p><?php echo($x->makeClickableLinks(strip_tags($row['comment']))) ?></p>
				</div>
				
			</div>
			
			<?php } ?>
			
			
			
		</div>
		
		</div>
		
		</div>
		
	</div>
<?php include("../inc_/footer.php"); ?>
</body>
</html>