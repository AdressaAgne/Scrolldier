<?php 
	include('admin/mysql/connect.php');
	include_once('admin/mysql/function.php');
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
	<title>Scrolldier.com</title>
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>

	<?php include('inc_/menu.php') ?>
	<div class="container">
		<p>If you got any feedback; negative, positive, constructive, bug report, ideas etc, please send a mail to <a href="mailto:support@scrolldier.com">support@scrolldier.com</a></p>
		
		<br />
		<p>Ads are on the page so i can afford to pay for the servers, if you want to get rid of the ads. You can Donate</p>
		<br />
		<p>When donating please include your Scrolldier name, so you can get your donor badge!</p>
		<p>€5+ will give you a Donor badge, <i class="icon-donor"></i></p>
		<p><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" class="left">
			<input type="hidden" name="cmd" value="_donations">
			<input type="hidden" name="business" value="agne240@me.com">
			<input type="hidden" name="lc" value="US">
			<input type="hidden" name="item_name" value="Orangee">
			<input type="hidden" name="no_note" value="0">
			<input type="hidden" name="currency_code" value="EUR">
			<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
			<input type="submit" class="btn-modern" name="" value="Donate" />
		</form>
		</p>
	</div>
<?php include("inc_/footer.php"); ?>
</body>
</html>