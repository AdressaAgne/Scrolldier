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
	<script src="jquery.js"></script>	 
	<script src="plugins/ckeditor/ckeditor.js"></script>	
</head>
<body style="padding-bottom: 0px;">
	<?php include('inc_/menu.php'); ?>
 	<div class="container clearfix">
 	
 		<?php 
 			function get_file_extension($file_name) {
 				return substr(strrchr($file_name,'.'),1);
 			}
 			
	 		$files = scandir('tiles/');
	 		foreach($files as $file) {
	 		
	 		$name = str_replace(".png", "", $file);
	 		$name = str_replace("_result", " ", $name);
	 		
	 		 if (get_file_extension($file) == "png") {
	 		 echo("<div class='div-half left div-margin'>");
	 		  echo("<h4>".$name."</h4>");
	 		 echo("<img src='tiles/".$file."' alt='' />");
	 		 echo("</div>");
	 		 }
	 		}
 		 ?>
 	
 	</div>
 	<?php include("inc_/footer.php"); ?>
</body>
</html>