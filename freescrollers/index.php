<?php 
	if (isset($_POST['send'])) {
	
		$from = "freescrollers@scrolldier.com";
		$subject = "Freescrollers";
		$to = "agne240@me.com";
		
		$message = "<div style=\"padding:10px;height:100%;width:100%;display:block;color:#121314;\"><h2>Freescroller Signup</h2><p>".$_POST['ign']." send restarted on <a href='http://freescrollers.scrolldier.com/'>freescrollers.scrolldier.com</a></p></div>";
		
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1". "\r\n";
		$headers  .= "From: $from\r\n";
		
		if (mail($to, $subject, $message, $headers)) {
			$_GET['success'] = "Done!";
		}
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Freescrollers</title>
	<link rel="icon" type="image/png" href="../img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="http://dev.scrolldier.com/css/main.css" />
</head>

<body>
	<div class="container">
		<div class="page-header align-center">
			<h2>Welcome Stranger</h2>
		</div>
		<?php if (isset($_GET['success'])) { ?>
			<div class="container dialog" id="successcontainer" style="top: 20px;">
				<div class="row">
					<div class="col-12 tag success">
						<div class="align-center"><p id="successMessage"><?=$_GET['success']?></p></div>
					</div>
				</div>
			</div>
		<?php } ?>
		<form method="post" action="">
			<div class="form-element col-4 col-offset-4">
				<label>In Game Name</label>
				<input type="text" id="" name="ign" value="" placeholder="In Game Name" />
			</div>
			<div class="form-element col-4 col-offset-4">
				<button type="submit" class="btn" name="send">Send</button>
			</div>
		</form>
	</div>
</body>
</html>