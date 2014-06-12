<?php 
	include('../admin/mysql/connect.php');
	include_once('../admin/mysql/function.php');
	$x = new xClass();
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}
	
	if (isset($_SESSION['username'])) {
		header('location: ../index.php');
	}
	
	if (isset($_POST['lign']) && isset($_POST['lpassword'])) {
		$login = $x->login($_POST['lign'], $_POST['lpassword']);
		if ($login === 1) {
			if (isset($_SESSION['lign'])) {
				if (isset($_GET['re']) && !empty($_GET['re'])) {
					header('location: '.$_GET['re']);
				} else {
					header('location: ../index.php');
				}
				
			}
		} else {
			$_GET['error'] = "Wrong login information";
			unset($_GET['success']);
		};
	}
	
	if (isset($_POST['ign']) && isset($_POST['mail'])) {
	
		//POST values ign, mail, key, pw, pwa
		
		//if user has input a ign
			if (isset($_POST['ign']) && !empty($_POST['ign'])) {
				
				
				//if user has a 1st pw
				if (isset($_POST['pw']) && !empty($_POST['pw'])) {
					//if user has 2nd pw
					if (isset($_POST['pwa']) && !empty($_POST['pwa'])) {
						//is pw1 === pw2
						if ($_POST['pw'] === $_POST['pwa']) {
						
						//settings Vars
							$ign = $_POST['ign'];
							$pw = sha1($_POST['pw']);
							$mail = $_POST['mail'];
							$key = sha1(microtime().rand());
							$rank = 4;
								
						if ($x->playerExist($ign)) {
						
							//getting IGN player head ID
							$url = "http://a.scrollsguide.com/player?name=".$_POST['ign']."&avatar";
							$json = file_get_contents($url);
							$data = json_decode($json, TRUE);
							if ($data['msg'] != "success") { 
								$headID == 1;
								$_GET['info'] .= 'Could not get In-Game Player data for '.$ign.'<br/>';
								$_GET['info'] .= $ign.' may not exist In Game or there was an error<br/>';
							} else {
								$headID = $data['data']['avatar'][0]['head'];
								
								//prepear Quary
								$aQuery = $db->prepare("INSERT INTO accounts (ign, rank, password, mail, betaKey, headID) VALUES (:ign, :rank, :password, :mail, :betaKey, :headID)");
								
								//prepare Values
								$arr = array(
										'ign' => $ign,
										'rank' => $rank,
										'password' => $pw,
										'mail' => $mail,
										'betaKey' => $key,
										'headID' => $headID
									);
									
								//insert values
								$x->arrayBinder($aQuery, $arr);
								
								//execute Query
							
								if ($aQuery->execute()) {
									$_GET['success'] .= 'Account Registred<br/>';
									try {
									    	$from = "noreply@scrolldier.com";
									    	$subject = "Scrolldier.com Mail Confirme";
									      	$to = $mail;
									      
									      $message = "<div style=\"padding:10px;height:100%;width:100%;display:block;color:#222222;\">
									      	<img src='http://scrolldier.com/img/Scrolldier.png' style=\"width: 200px;\" />
									      	<h2>Confirm Your Mail</h2>
									      	<p>Your new key to confirm your mail: ".$key."</p>
									      	<p>Click this link to confirm: <br />
									      	<a href='".$main."confirm.php?c=".$key."'>".$main."confirm.php?c=".$key."</a></p>
									      
									      	<p>Thank you so much for joining Scrolldier.com, All feedback is appreciated.</p>
									      	<p>Feedback can be sent to <a href='mailto:support@scrolldier.com'>support@scrolldier.com</a>.</p>
									      	
									      	<p>-Orangee @ Scrolldier.com</p>
									      </div>";
									      
									      
									      $headers = "MIME-Version: 1.0\r\n";
									      $headers .= "Content-type: text/html; charset=iso-8859-1". "\r\n";
									      $headers  .= "From: $from\r\n";
									      
									      if (mail($to, $subject, $message, $headers)) {
									      	
									   	  }
									} catch (PDOException $e) {
										echo($e);
									}
								}
							
							
							}
							
							} else {
								$_GET['info'] .= 'In Game Name already used <br/>';
							}
						} else {
							$_GET['info'] .= 'Passwords Do not match <br/>';
						}
					} else {
						$_GET['info'] .= 'Repeat your password <br/>';
					}
				} else {
					$_GET['info'] .= 'No password Selected <br/>';
				}
				
			} else {
				$_GET['info'] .= 'No In-Game Name entered <br/>';
			}
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolldier.com</title>
	<link rel="icon" type="image/png" href="../img/bunny.png">	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="../css/style.css" />
</head>
<body>
	</div>
	
	
	<div class="body" id="blog">
		<div class="logo" onclick="location.href='index.php'"></div>
		<div class="container">
			<div class="div-4 clearfix">
				
				<div class="div-4">
					<h3>Welcome Scrolldier, the open beta testing has arrived! </h3>
					<p class="text-white">Welcome to the beta test of Scrolldier.com, I hope you will help us find bugs and things that look ugly. If you have ideas or bugs send a mail to <a href="mailto:support@scrolldier.com">support@scrolldier.com</a>. If you got any questions you can also send a mail or just Ping Orangee in IRC chat (#scrollsguide)</p>
				</div>
			<div class="left div-1" style="margin-right: 10px;">
				
				<div class="div-1 left scrolls div-margin">
					<h4>Already got an Account?</h4>
					<form method="post" action="">
						<div class="div-1 div-margin">
							<label for="ign">In Game Name</label><br />
							<input type="text"  class="textbox full div-2" name="lign" id="ign" value="" placeholder="In Game Name" />
						</div>
						<div class="div-1 div-margin">
							<label for="lpassword">Password</label><br />
							<input type="password" class="textbox full div-2" name="lpassword" id="lpassword" value="" placeholder="Password" />
						</div>
						<div class="div-1 div-margin">
							<input type="submit" name="" class="btn" value="Login" />
						</div>
					</form>
				</div>
				
				<div class="div-1 left scrolls div-margin">
					<p>Wanna help us pay for the servers?</p>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_donations">
					<input type="hidden" name="business" value="agne240@me.com">
					<input type="hidden" name="lc" value="US">
					<input type="hidden" name="item_name" value="Orangee">
					<input type="hidden" name="no_note" value="0">
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
					
				</div>
			</div>	
				<div class="div-3 scrolls div-margin">
					<h4>Sign up for Open Beta</h4>
					<?php if (isset($_GET['info'])) { ?>
						<p class="color-red"><?php echo($_GET['info']) ?></p>
					<?php } ?>
					<?php if (isset($_GET['success'])) { ?>
						<p class="color-green"><?php echo($_GET['success']) ?></p>
					<?php } ?>
						<form method="post" action="">
							<div class="div-3">
								<div class="div-3">
									<label for="ign">In Game Name</label><br />
									<input type="text" class="textbox full div-1" name="ign" id="ign" value="" placeholder="In Game Name" />
								</div>
								<div class="div-3">
								
									<label for="mail">Mail</label><br />
									<input type="email" class="textbox full div-1" name="mail" id="mail" value="<?php if (!empty($_GET['mail']) && isset($_GET['mail'])) {
										echo($_GET['mail']);
									} ?>" placeholder="Mail" />
								</div>
							</div>
							
							<div class="div-3 settings-element">
								<div class="div-3">
									<label for="Password">Password</label><br />
									<input type="password" class="textbox full div-1" name="pw" id="Password" value="" placeholder="Password" />
								</div>
								<div class="div-3">
									<label for="PasswordA">Repeat Password</label><br />
									<input type="password" class="textbox full div-1" name="pwa" id="PasswordA" value="" placeholder="Repeat Password" />
								</div>
							</div>
							<div class="div-submit settings-element">
								<input type="hidden" name="submit" value="submit" />
								<input type="submit" class="btn" name="" value="Create account" />
							</div>
						</form>
				</div>	
			</div>
		</div>
	</div>
<?php include("../inc_/footer.php"); ?>
</body>
</html>