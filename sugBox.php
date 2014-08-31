<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
include('admin/mysql/badges.php');
include('admin/mysql/deck.php');
$x = new xClass();
$badge = new badges();
$deck = new deck();

session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}
if (!isset($_SESSION['username'])) {
	header("location: login.php?re=/suggest");
}


if (isset($_POST['suggestSubmit'])) {

	//Table: suggestions_box, user varchar(255), text Text
	$query = $db->prepare("INSERT INTO suggestions_box (user, text) VALUES(:user, :text)");
	$arr = array(
			'user' => $_SESSION['username'],
			'text' => $_POST['text']
		);
	
	$x->arrayBinder($query, $arr);
	
	if ($query->execute()) {
		$_GET['w'] = "Thanks for you suggestion, I will send you a PM when this has bean added to scrolldier.com";
	}	
}
	
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolls - Alternative Profile Page</title>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="../jquery.js"></script>	 
	<script src="../plugins/ckeditor/ckeditor.js"></script>	
		
</head>
<body>
	 <?php include('inc_/menu.php'); ?>
	 
	 <div class="container">
	 	<h1>Suggestion Box / Bug Reports</h1>
	 
	 	<div class="div-4">
		 	<form method="post" action="">
		 		<textarea class="textbox div-4" name="text" rows="10" placeholder="Write a Suggestion for Scrolldier"></textarea>
		 	
		 		<div class="div-4">
		 			<button type="submit" name="suggestSubmit" class="btn-modern btn-no-margin">Submit Suggestion</button>
		 		</div>
		 	</form>
	 	</div>
	 </div>


	<?php include("inc_/footer.php"); ?>
</body>
</html