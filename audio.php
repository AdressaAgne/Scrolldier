<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
$x = new xClass();

session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolls - Audio</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="icon" type="image/png" href="img/bunny.png">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="../jquery.js"></script>	 
	<script src="../plugins/ckeditor/ckeditor.js"></script>	
</head>
<body style="padding-bottom: 0px;">
	<?php include('inc_/menu.php'); ?>
 	<div class="container clearfix">
 	
 		<?php 
 			function get_file_extension($file_name) {
 				return substr(strrchr($file_name,'.'),1);
 			}
 			
	 		$files = scandir('audio/');
	 		foreach($files as $file) {
	 		 if (get_file_extension($file) == "ogg") {
	 		 echo("<div class='div-half left div-margin'>");
	 		  echo("<h4>".str_replace(".ogg", "", $file)."</h4>");
	 		  echo("<audio controls>
	 		    <source src='audio/".$file."' type='audio/ogg'>
	 		  Your browser does not support the audio element.
	 		  </audio>");
	 		 echo("</div>");
	 		 }
	 		}
 		 ?>
 	
 	</div>
 	<?php include("inc_/footer.php"); ?>
</body>
</html>