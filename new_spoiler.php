<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
$x = new xClass();

session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}
if (!isset($_SESSION['username']) && $_SESSION['rank'] <= 2) {
	header("location: login.php");
}

	if (isset($_POST['html']) && !empty($_POST['html']) && isset($_SESSION['username']) && $_SESSION['rank'] <= 2) {
		
		if (empty($_POST['name'])) {
			$_POST['name'] = "Unknown";
		}
		
		if (isset($_POST['isHidden'])) {
			$hidden = 1;
		} else {
			$hidden = 0;
		}
		
		if ($x->newPost($_POST['header'], $_POST['html'], $_POST['name'], $hidden)) {
			header('location: ../?patch');
		}
		
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolls - Alternative Profile Page</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="icon" type="image/png" href="img/bunny.png">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="<?php echo($main) ?>jquery.js"></script>	 
	<script src="<?php echo($main) ?>plugins/ckeditor/ckeditor.js"></script>	
		
</head>
<body>
	 <?php include('inc_/menu.php'); ?>
	 
	 <div class="indexbg fullScreen">
	 	<div class="container">
	 		<div id="patchNews" class="clearfix">
	 			
	 			
	 			<div class="scrollsHardBack">
					<form method="post" action="">
						<div class="div-3">
							<input type="text" class="textbox full" name="header" value="" placeholder="Header" />
						</div>
						<div class="div-3">
							<input type="checkbox" name="isHidden" id="isHidden" value="" />
							<label for="isHidden">Make post hidden</label>
						</div>	
						<div class="div-4">
							<textarea class="ckeditor" name="html" id="editor"></textarea>
						</div>
						<br />
						<div class="div-3">
							<input type="hidden" name="name" value="<?php echo($_SESSION['username']) ?>" placeholder="User" />
							<input type="submit" class="btn" name="submit" value="Post" />
						</div>
					</form>
	 			</div>
	 		</div>
	 	</div>
	 </div>

<?php include("inc_/footer.php"); ?>
</body>
</html>