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
		$query->execute();			
	} 
	
	if (isset($_POST['postID']) && !empty($_POST['postID'])) {
		$x->delComment($_POST['postID']);
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
		<div class="containerComment">	
		
		<?php
		$query = $db->prepare("SELECT * FROM comment WHERE commentToID=:id AND cWhere = 3 ORDER BY TIME DESC");
		$arr = array(
				'id' => $fanScroll['id']
			);
		$x->arrayBinder($query, $arr);	
			
		function makeClickableLinks($s) {
		  return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
		}
		
		
		$query->execute();		
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				
		?>
		
			<div class="avatar scrolls">
				<img src="<?php echo($main) ?>resources/head_<?php echo($row['headID']) ?>.png" alt="" />
			</div>
			<div class="commentPost scrolls">
				<h4 class="clearfix"><a class="left" href="<?php echo($main) ?>user/<?php echo(strip_tags($row['byUser'])) ?>"><?php echo(strip_tags($row['byUser'])) ?></a>
				<?php $userGuild = $x->getGuild($row['byUser']) ?>
				
				
				<?php if (!$x->hasGuild($row['byUser'])) { ?>
					<div class="left" style="margin-left: 10px;">
							<img src="<?php echo($userGuild['badge_url']) ?>" height="16px" alt="" />
					</div>
				<?php } ?>
				<?php if (isset($_SESSION['username']) && $_SESSION['rank'] < 3) { ?>
				<small>
				
				<form method="post" class="right" action="">
					<input type="hidden" name="postID" value="<?php echo($row['id']) ?>" />
					<input type="submit" class="delBtn" name="" value="Delete" />
				</form>
				<form method="post" class="right" action="">
					<input type="hidden" name="warningUser" value="<?php echo($row['byUser']) ?>" />
					<input type="hidden" name="warningPost" value="<?php echo($row['id']) ?>" />
					<input type="submit" class="warBtn" name="" value="Warning<?php if ($row['Warning'] >= 1) {
						echo("(".$row['Warning'].")");
					} ?>" />
				</form>
				</small>
				<?php } ?>
				
				<?php $thisRank = $x->getUserRank($row['byUser']); ?>
				<?php $thisUser = $row['byUser']; ?>
				<?php include("../inc_/icon_comment.php"); ?>
				
				</h4>
				<p><?php echo(makeClickableLinks(strip_tags($row['comment']))) ?></p>
				
			</div>
			
			<?php } ?>
			
			
			
		</div>
		<?php if (isset($_SESSION['username'])) { ?>
		<div class="containerComment">
			<div class="avatar scrolls">
				<?php if (isset($_SESSION['username'])) { ?>
					<img src="<?php echo($main) ?>resources/head_<?php echo($_SESSION['headID']) ?>.png" alt="" />
				<?php } else { ?>
					<img src="<?php echo($main) ?>resources/head_195.png" alt="" />
				<?php } ?>
			</div>
			<div class="scrolls comment clearfix">
				<h4>Write a comment about this?</h4>
				<form method="post" class="commentBox" action="">
				
					<?php if (isset($_SESSION['username'])) { ?>
						<input type="hidden" class="textbox full div-3" name="name" value="<?php echo($_SESSION['username']) ?>" />
						<input type="hidden" name="headID" value="<?php echo($_SESSION['headID']) ?>" />
					<?php } else { ?>
						<input type="text" class="textbox full div-3" name="name" placeholder="InGameName" value="" />
						<input type="hidden" name="headID" value="195" />
					<?php } ?>
				
					
					<textarea name="comment" class="textarea full" placeholder="Comment"></textarea><br />
					<div class="div-btn">
					<input type="submit" class="btn-modern btn-no-margin" name="submit" value="Submit" />
					</div>
				</form>
			</div>
		</div>
		<?php } ?>
		</div>
		
		</div>
		
	</div>
<?php include("../inc_/footer.php"); ?>
</body>
</html>