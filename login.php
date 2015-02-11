<?php 
	include('admin/mysql/connect.php');
	include_once('admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	
	if (isset($_POST['remember_user'])) {
		
		$query = $db->prepare("SELECT * FROM accounts WHERE ign=:username AND password=:password");
		$arr = array(
				'username' => $_POST['lign'],
				'password' => sha1($_POST['lpassword'])
			);
		
		$x->arrayBinder($query, $arr);
		
		$query->execute();
		
		$token = sha1(microtime());
		//6c5b810c938882a8e4d04e24313987885909f3ff
		$newToekn = $db->prepare("UPDATE accounts SET betaKey = :token WHERE ign = :username");
		$newToeknArr = array(
				'token' => $token,
				'username' => $_POST['lign']
			); 
		
		$x->arrayBinder($newToekn, $newToeknArr);
		if ($newToekn->execute()) {
			if ($query->rowCount() === 1) {
				$row = $query->fetch(PDO::FETCH_ASSOC);
				
				$expire=time()+60*60*24*30;
				setcookie("remember_user", true, $expire);
				setcookie("scrolldier_usernmae", $_POST['lign'], $expire);
				setcookie("scrolldier_token", $token, $expire);
			}
		}
		
	}
	
	
	if (isset($_COOKIE['remember_user'])) {
	
		if (isset($_COOKIE['scrolldier_usernmae'])) {
			
			if (isset($_COOKIE['scrolldier_token'])) {
				$login = $x->authLogin($_COOKIE['scrolldier_usernmae'], $_COOKIE['scrolldier_token']);
			}
			
		}
			
	}
	
	
	if (isset($_POST['lign']) && isset($_POST['lpassword'])) {
		$login = $x->login($_POST['lign'], $_POST['lpassword']);
		if ($login === 1) {
			
		} else {
			$_GET['error'] = "Wrong login information<br />Forgot password? click <a href='".$main."reset.php'>here</a>";
			unset($_GET['success']);
		};
	}
	
	if (isset($_SESSION['username'])) {
		if (isset($_GET['re']) && !empty($_GET['re'])) {
			$new_url = preg_replace('/&?logout/', '', $_GET['re']);
			header('location: '.$main.$new_url);
			
		} else {
			header('location: '.$main);
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
	
	<div style="width: 300px;" class="clearfix div-center">
		<h2 class="div-4 modern">Login</h2>
		
		<?php if (isset($_GET['error'])) { ?>
			<div class="div-4">
				<span class='color-red div-4'><?php echo($_GET['error']) ?></span>
			</div>
		<?php } ?>
		<form method="post" class="div-4" action="">
			<div class="div-4 div-margin">
				<label for="ign">In Game Name</label><br />
				<input type="text" class="textbox full div-4" name="lign" id="ign" value="" placeholder="In Game Name" />
			</div>
			<div class="div-4 div-margin">
				<label for="lpassword">Password</label><br />
				<input type="password" class="textbox full div-4" name="lpassword" id="lpassword" value="" placeholder="Password" />
			</div>
			<div class="div-3">
				<input type="checkbox" class="normal_checkbox" name="remember_user" id="remember_user"  value="" />
				<label for="remember_user" class="normal_checkbox"></label>
				<label for="remember_user" class="hand">Remember me for 1 month (Uses Cookies)</label>
			</div>
			<div class="div-4 div-margin">
				<input type="submit" name="" class="btn-modern btn-no-margin" value="Login" />
				<span>Don't have an account? <a href="<?php echo($main) ?>u/reg.php">Sign Up</a></span>
			</div>
		</form>
	</div>
<?php include("inc_/footer.php"); ?>
</body>
</html>