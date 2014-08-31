<?php 
include('../admin/mysql/connect.php');
include('../admin/mysql/function.php');
$x = new xClass();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolls - Editor Test Page</title>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
	<link rel="icon" type="image/png" href="img/bunny.png">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="<?php echo($main) ?>jquery.js"></script>	 
	<script src="<?php echo($main) ?>plugins/ckeditor/ckeditor.js"></script>	
		
</head>
<body>
	 <?php include('../inc_/menu.php'); ?>
	 
	 <div class="indexbg fullScreen">
	 	<div class="container">
	 		<div id="patchNews" class="clearfix">
	 			<div class="scrollsHardBack">
					<form method="post" action="">
						<?php include("../inc_/editor.php") ?>
					</form>
	 			</div>
	 		</div>
	 	</div>
	 </div>

<?php include("../inc_/footer.php"); ?>

</body>
</html>