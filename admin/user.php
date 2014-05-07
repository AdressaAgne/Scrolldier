<?php 
include('mysql/connect.php');
include('mysql/function.php');
$x = new xClass();

	if (isset($_POST['submit']) & !empty($_POST['userID'])) {
		
		
		if (empty($_POST['name'])) {
			$_POST['name'] = "Unknown";
		}
		
		if ($x->editPost($_POST['id'], $_POST['header'], $_POST['html'], $_POST['name'])) {
			header('location: ../?patch='.$_POST['id']);
		}
		
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolls - Alternative Profile Page</title>
	<link rel="stylesheet" href="../css/master.css" />
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="../jquery.js"></script>	 
	<script src="../plugins/ckeditor/ckeditor.js"></script>	
</head>
<body style="padding-bottom: 0px;">
	 <?php include('../menu.php'); ?>
	 
	 <div class="indexbg fullScreen">
	 	<div class="container">
	 		<div id="patchNews" class="clearfix">
	 			<?php
	 			$query = $db->prepare("SELECT * FROM scrolls WHERE id=:id");
	 			$arr = array(
	 					'id' => ""
	 				);
	 			
	 			$x->arrayBinder($query, $arr);
	 			$query->execute();		
	 			$row = $query->fetch(PDO::FETCH_ASSOC);
	 					
	 			?>	

	 			<div class="scrollsHardBack">
					<form method="post" action="">
						<input type="hidden" name="userID" value="<?php echo($_SESSION['user_id']) ?>" />
						<input type="submit" class="btn" name="submit" value="summon key" />
					</form>
	 			</div>
	 		</div>
	 	</div>
	 </div>


</body>
</html>