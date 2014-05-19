<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
$x = new xClass();
session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}

if (isset($_POST['submitDeletePost']) && isset($_SESSION['username'])) {
		if ($_SESSION['rank'] <= 2) {
		$query = $db->prepare("DELETE FROM scrolls where id=:id");
		$arr = array(
				'id' => $_POST['postID']
			);
		
		$x->arrayBinder($query, $arr);

		if ($query->execute()) {
			header("location: admin.php");
		}
	}
}

if (isset($_POST['name']) && isset($_POST['submit']) && isset($_POST['comment']) && isset($_SESSION['username'])) {
	
	$query = $db->prepare("INSERT INTO comment (byUser, comment, commentToID, headID) VALUES (:name, :comment, :commentToID, :headID)");
	$arr = array(
			'name' => $_POST['name'],
			'comment' => $_POST['comment'],
			'commentToID' => $_GET['s'],
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
if (!isset($_GET['s']) || empty($_GET['s'])) {
	$_GET['s'] = 1;
}

$query = $db->prepare("SELECT * FROM scrolls WHERE id=:id");
$arr = array(
		'id' => $_GET['s']
	);

$x->arrayBinder($query, $arr);
$query->execute();	
$row = $query->fetch(PDO::FETCH_ASSOC)	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo($row['header']) ?> @ Scrolldier.com</title>
	<link rel="icon" type="image/png" href="<?php echo($main) ?>img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
	<?php include("inc_/ad/main.php"); ?>
</head>
<body>
	<?php include('inc_/menu.php') ?>
	<div class="body" id="blog">
		
		<div class="container">
			
			<div class="news">
				<!-- Blog -->
				
				<div class="last">
					<div class="header">
						<h3><?php echo($row['header']) ?><small><?php if (isset($_SESSION['username']) && ($_SESSION['rank'] == 1 || $_SESSION['username'] == $row['byName']))  { ?>
								
								<form method="post" action="" class="right">
									<input type="button" class="btn-modern" onclick="location.href='edit.php?edit=<?php echo($row['id']) ?>'" name="" value="Edit" />
									<input type="hidden" name="postID" value="<?php echo($row['id']) ?>" />
									<input type="submit" name="submitDeletePost" class="btn-modern" value="Delete" />
								</form>
								
						<?php } ?></small></h3>
						<small><?php echo($x->ago($row['time'])) ?>, By: <a href="<?php echo($main) ?>user/<?php echo($row['byName']) ?>"><?php echo($row['byName']) ?></a></small>
					</div>
					<div class="news_content">
						<?php echo($row['html']) ?>
					</div>
				</div>
				
				
				<div class="containerComment">	
				
				<?php
				$query = $db->prepare("SELECT * FROM comment WHERE commentToID=:id AND cWhere = 1 ORDER BY TIME DESC");
				$arr = array(
						'id' => $_GET['s']
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
						<small>Comments: <?php echo($x->totalComments($_GET['s'])) ?></small>
						<form method="post" class="commentBox" action="">
						
							<?php if (isset($_SESSION['username'])) { ?>
								<input type="hidden" class="textbox full div-3" name="name" value="<?php echo($_SESSION['username']) ?>" />
								<input type="hidden" name="headID" value="<?php echo($_SESSION['headID']) ?>" />
							<?php } else { ?>
								<input type="text" class="textbox full div-3" name="name" placeholder="InGameName" value="" />
								<input type="hidden" name="headID" value="195" />
							<?php } ?>
						
							
							<textarea name="comment" class="textarea full" placeholder="Comment"></textarea><br />
							<div class="div-3">
							<input type="submit" class="btn" name="submit" value="Post" />
							</div>
						</form>
					</div>
				</div>
				<?php } ?>
			</div>
			
			<?php if (($x->hasDonated($_SESSION['username']) == false && $_SESSION['rank'] == 4) || !isset($_SESSION['username'])) { ?>	
			<div class="news_wall">
				<?php include("inc_/ad/squere2.php"); ?>
			</div>
			<div class="last">
				<?php include("inc_/ad/banner.php"); ?>
			</div>
			<?php } ?>
		</div>
	</div>
<?php include("inc_/footer.php"); ?>
</body>
</html>