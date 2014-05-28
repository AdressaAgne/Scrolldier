<?php 
	include('admin/mysql/connect.php');
	include_once('admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	
	if (!isset($_SESSION['username'])) {
		header("location:".$main);
	}
	
	if (!isset($_GET['c'])) {
	 $query = $db->prepare("SELECT * FROM accounts WHERE ign=:ign");
	 $arr = array(
	 		'ign' => $_SESSION['username']
	 	);
	 
	 $x->arrayBinder($query, $arr);
	 
	 $query->execute();
	 
	 $user = $query->fetch(PDO::FETCH_ASSOC);
	 
     	  	try {
	            	$from = "noreply@scrolldier.com";
	            	$subject = "Scrolldier.com Mail Confirme";
	              	$to = $user['mail'];
	              
	              $message = "<div style=\"padding:10px;height:100%;width:100%;display:block;color:#222222;\">
	              	<img src='http://scrolldier.com/img/Scrolldier.png' style=\"width: 200px;\" />
	              	<h2>Confirm Your Mail</h2>
	              	<p>Your new key to confirm your mail: ".$user['betaKey']."</p>
	              	<p>Click this link to confirm: <br />
	              	<a href='".$main."confirm.php?c=".$user['betaKey']."'>".$main."confirm.php?c=".$user['betaKey']."</a></p>
	              
	              	<p>Thank you so much for joining Scrolldier.com, All feedback is appreciated.</p>
	              	<p>Feedback can be sent to <a href='mailto:support@scrolldier.com'>support@scrolldier.com</a>.</p>
	              	
	              	<p>-Orangee @ Scrolldier.com</p>
	              </div>";
	              
	              
	              $headers = "MIME-Version: 1.0\r\n";
	              $headers .= "Content-type: text/html; charset=iso-8859-1". "\r\n";
	              $headers  .= "From: $from\r\n";
	              
	              if (mail($to, $subject, $message, $headers)) {
	              	header("location: ".$main."?w=Confirmation mail sent to your mail account. Please verify it");
	           	  }
			} catch (PDOException $e) {
				echo($e);
			}
				
	} else {
		$query = $db->prepare("UPDATE accounts SET mailConfirmed=1 WHERE betaKey=:key");
		$arr = array(
				'key' => $_GET['c']
			);
		
		$x->arrayBinder($query, $arr);
		
		$query->execute();
		
		header("location: ".$main."?w=Mail now Confirmed");
	}
	
 ?>