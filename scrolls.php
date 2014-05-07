<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
$x = new xClass();
session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}
if (isset($_POST['name']) && isset($_POST['submit']) && isset($_POST['comment'])) {
	
	$query = $db->prepare("INSERT INTO comment (byUser, comment, commentToID, headID, cWhere) VALUES (:name, :comment, :commentToID, :headID, 2)");
	$arr = array(
			'name' => $_POST['name'],
			'comment' => $_POST['comment'],
			'commentToID' => $_GET['d'],
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

if (isset($_POST['VoteUp']) && !empty($_POST['VoteUp'])) {
	$x->deckVote($_POST['deckID'], true, $_SESSION['username']);
}
if (isset($_POST['VoteDown']) && !empty($_POST['VoteDown'])) {
	$x->deckVote($_POST['deckID'], false, $_SESSION['username']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolldier.com - Deck</title>
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>
	<?php include('inc_/menu.php') ?>
	<div class="body" id="blog">
		
		<div class="container">
			<?php
				$query = $db->prepare("SELECT * FROM scrollsCard");
				$query->execute();		
					
					while ($card = $query->fetch(PDO::FETCH_ASSOC)) {
				
				 ?>
				 <?php if (file_exists("resources/cardImages/".$card['image'].".png")) { ?>
				 
					<div class="modern">
						<span class="left">
							<img class="listScroll" src="resources/cardImages/<?php echo($card['image']) ?>.png" alt="" />
						</span>
						 
						 <span class="">
					<?php if (!empty($card['costorder'])) { ?>
						<i class="icon-order small"></i>
					<?php } ?>
					<?php if (!empty($card['costgrowth'])) { ?>
						<i class="icon-growth small"></i>
					<?php } ?>
					<?php if (!empty($card['costdecay'])) { ?>
						<i class="icon-decay small"></i>
					<?php } ?>
					<?php if (!empty($card['costenergy'])) { ?>
						<i class="icon-energy small"></i>
					<?php } ?>
						</span>
						<span><?php echo($card['name']); ?> - <?php echo($card['image']); ?></span>
					</div>
					<?php }
				}
				 ?>
				
			</div>
			
		</div>
	</div>
<?php include("inc_/footer.php"); ?>
</body>
</html>