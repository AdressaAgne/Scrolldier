<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
$x = new xClass();

session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}
if (!isset($_SESSION['username'])) {
	header("location: login.php");
}
	if (isset($_POST['html']) & !empty($_POST['html']) && isset($_SESSION['username']) && $_SESSION['rank'] <= 2) {
		
		
		if (empty($_POST['name'])) {
			$_POST['name'] = "Unknown";
		}
		
		if (isset($_POST['isHidden'])) {
			$hidden = 1;
		} else {
			$hidden = 0;
		}
		
		if ($x->editPost($_POST['id'], $_POST['header'], $_POST['html'], $_POST['name'], $hidden)) {
			header('location: ../spoiler.php?s='.$_POST['id']);
		}
		
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolls - Alternative Profile Page</title>
	<link rel="icon" type="image/png" href="img/bunny.png">
	<link rel="stylesheet" href="css/style.css" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="../jquery.js"></script>	 
	<script src="../plugins/ckeditor/ckeditor.js"></script>	
</head>
<body style="padding-bottom: 0px;">
	 <?php include('inc_/menu.php'); ?>
	 
	 <div class="indexbg fullScreen">
	 	<div class="container">
	 		<div id="patchNews" class="clearfix">
	 			<?php
	 			if (!isset($_GET['edit']) || empty($_GET['edit'])) {
	 				$_GET['edit'] = 1;
	 			}
	 			
	 			$query = $db->prepare("SELECT * FROM scrolls WHERE id=:id");
	 			$arr = array(
	 					'id' => $_GET['edit']
	 				);
	 			
	 			$x->arrayBinder($query, $arr);
	 			$query->execute();		
	 			$row = $query->fetch(PDO::FETCH_ASSOC);
	 				
	 			 
	 			if ($row['isHidden'] == 1) {
	 				$isHidden = "checked";
	 			} else {
	 				$isHidden = "";
	 			}
	 			?>	
	 			<?php if (isset($_SESSION['username']) && ($_SESSION['rank'] == 1 || $_SESSION['username'] == $row['byName'])) { ?>
	 			<div class="scrollsHardBack">
					<form method="post" action="">
						<div class="div-3">
							<input type="text" name="header" class="textbox full" value="<?php echo($row['header']) ?>" placeholder="Header" />
						</div>
						<div class="div-3">
							<input <?php echo($isHidden) ?> type="checkbox" name="isHidden" id="isHidden" value="" />
							<label for="isHidden">Make post hidden</label>
						</div>
						<div class="div-4">
							<textarea class="ckeditor" id="editor" name="html"><?php echo($row['html']) ?></textarea>
						</div>
						<div class="div-3">
							<input type="hidden" name="name" value="<?php echo($row['byName']) ?>" placeholder="User" />
							<input type="hidden" name="id" value="<?php echo($row['id']) ?>" />
							<input type="submit" class="btn" name="submit" value="Post" />
						</div>
					</form>
	 			</div>
	 			<?php } else { ?>
	 				<div class="scrollsHardBack">
	 					<p>No access!</p>
	 				</div>
	 			<?php } ?>
	 		</div>
	 	</div>
	 </div>

<?php include("inc_/footer.php"); ?>
</body>
</html>