<?php 
	include('admin/mysql/connect.php');
	include_once('admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	
	if (isset($_POST['mail'])) {
		$newpw = uniqid();
		
		$query = $db->prepare("SELECT * FROM accounts WHERE mail=:mail");
		$arr = array(
				'mail' => $_POST['mail']
			);
		
		$x->arrayBinder($query, $arr);
		$query->execute();
		if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
						        
     	  try {
			if ($x->changePassword($newpw, $row['id'])) {
	            	$from = "noreply@scrolldier.com";
	            	$subject = "Scrolldier.com Password Reset";
	              	$to = $row['mail'];
	              
	              $message = "<div style=\"padding:10px;height:100%;width:100%;display:block;color:#222222;\">
	              	<img src='http://alpha.scrolldier.com/img/Scrolldier.png' style=\"width: 200px;\" />
	              	<h2>Passwrod reset</h2>
	              	<p>You or someone else just did a reset on your password</p>
	              	<p>Your new Password: ".$newpw."</p>
	              	<p>Click this link to login: <br />
	              	http://scrolldier.com/login.php</p>
	              	
	              	<p>To change your password again, go to your profile by clicking your name in the menu. then click 'edit profile'</p>
	              	
	              	<p>Thank you so much for joining Scrolldier.com, All feedback is appreciated.</p>
	              	<p>Feedback can be sent to <a href='mailto:support@scrolldier.com'>support@scrolldier.com</a>.</p>
	              	
	              	<p>-Orangee @ Scrolldier.com</p>
	              </div>";
	              
	              
	              $headers = "MIME-Version: 1.0\r\n";
	              $headers .= "Content-type: text/html; charset=iso-8859-1". "\r\n";
	              $headers  .= "From: $from\r\n";
	              
	              if (mail($to, $subject, $message, $headers)) {
	              	 $info = "Password reset for ".$_POST['mail']."<br />Check your mail for a new password";
	           	  }
				}
			} catch (PDOException $e) {
				$error = $e;
			}

		} else {
			$error = "Could not find a user with that mail";
		}
				
	}
	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolldier.com</title>
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>
	<div class="logo"></div>
	
	<div class="loginContainer modern clearfix">
		<h1>forgot password?</h1>
		<form method="post" action="">
			<?php if (isset($error)) { ?>
				<span class="color-red"><?php echo($error) ?></span>
			<?php } ?>
			<?php if (isset($info)) { ?>
				<span class="color-green"><?php echo($error) ?></span>
			<?php } ?>
			<div class="div-1 div-margin">
				<label for="mail">e-mail</label><br />
				<input type="text" class="textbox full div-2" name="mail" id="mail" value="" placeholder="e-mail" />
			</div>
			<div class="div-1 div-margin">
				<input type="submit" name="" class="btn" value="Send me a new password" />
			</div>
		</form>
	</div>
<?php include("inc_/footer.php"); ?>
</body>
</html>