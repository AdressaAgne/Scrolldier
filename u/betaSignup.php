<?php 
	include('../admin/mysql/connect.php');
	include('../admin/mysql/function.php');
	$x = new xClass();
	
	if (isset($_POST['submit']) && isset($_POST['mail']) && !empty($_POST['mail'])) {
		if ($x->betaSignup($_POST['mail'])) {
			header("location: ?thanks");
		}
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome Scrolldier</title>
	<link rel="stylesheet" href="../css/style.css" />
	<link rel="icon" type="image/png" href="../img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
</head>
<body class="main">
<!--	<div class="box2" style="margin-top: 20px;">
		<h4 class="align-center" style="margin-top: 30px; color: #fff; position: absolute; z-index: 3; width: 728px;">Ads keep the site alive</h4>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

		<ins class="adsbygoogle"
		     style="display:inline-block;width:728px;height:90px; z-index: 2;"
		     data-ad-client="ca-pub-2480986580065735"
		     data-ad-slot="2262573990"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div>-->
	<div class="div-3" style="margin: 50px auto; float: none;">
	
	<?php if (isset($_GET['thanks'])) { ?>
		<div class="narrowContainer scrolls">
			<h2>Thanks for contributing to the development of scrolldiers.com</h2>
		</div>
	<?php } else { ?>
		<div class="narrowContainer scrolls">
			<h1>This site is still under construction</h1>
			<h1>Starting beta testing soon</h1>
			<br />
			<p>Basically this is a new fan site for scrolls, it will contain a user system, deck lists, a spoiler blog where all the spoilers from all the devs will be collected and brought to one place. Twitch Api, current online Twitch streams, a list of all streamers that stream scrolls on a regular base.</p>
			<br />
			<p>User search, search amongst all the in-game accounts of scrolls. look up gold, graphs, rating graphs, scrolls everything about a player.</p>
			<br />
			<p>The first months we will try a closed beta, when we get the core inn and some other stuff we will go to open beta.</p>
			
			<form method="post" class="betaSignup clearfix" action="">

					<h1>Sign up for the closed beta!</h1>
					<div class="div-3">
						<input type="email" id="mail" class="textbox full div-2" name="mail" value="" placeholder="Your mail" />
					</div>
					<div class="div-3">
						<input type="submit" class="btn" name="submit" value="Count me as a scrolldier" />
					</div>
			</form>
			
		</div>
	<?php } ?>
			<div class="div-3 scrolls" style="margin: 20px auto; float: none;">
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
				<p>Help us with scrolldier.com, this page will not contain any ads. This site are completely fan based. All donation will help us pay for the servers</p>
			</div>
		</div>
	<?php include("../inc_/footer.php"); ?>
</body>
</html>