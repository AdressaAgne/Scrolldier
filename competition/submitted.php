<?php 

	//databases
	require_once("controllers/pdo.php");
	require_once("controllers/accountController.php");
	require_once("controllers/deckController.php");
	include('../admin/mysql/connect.php');
	include_once('../admin/mysql/function.php');
	$x = new xClass();

	
	//pages
	require_once("controllers/texthandler.php");
	
	$deck = new Deck();
	$formating = new TextHandler();
	$account = new AccountController();
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Agne Ødegaard" />
	<meta name="description" content="" />
	<meta name="application-name" content="Scrolldier" />
	
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Apple Device: App-->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	
	<!-- Apple Device: Remove Status bar-->
	<meta name="apple-mobile-web-app-status-bar-style" content=“black”>
	
	<!--	Getting page title-->
	<title>Official Scrolls Pre-Constructed Deck Competition - View Decks</title>
	
	<!--Main css-->
	<link rel="stylesheet" href="css/style.css" />


	
	
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!--jQuery-1.11.1.min-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-49724500-1', 'scrolldier.com');
	  ga('send', 'pageview');
	
	</script>

</head>
	<body>
	<div class="container">	
	<div class="align-center">
		<img src="mojang_logo_new1.png" width="400px" alt="" /><br />
		<img src="http://scrolldier.com/img/Scrolldier_new.png" width="200px" alt="" />
	</div>
	<div class="row">
	
	<div class="page-header">
		<h2>Submitted Decks <small><a href="index.php">back</a></small></h2>
		<p>Take a look at the decks below that others have submitted. If you like what you see, make sure to click the green "Vote Up" button to show your appreciation. This will help the Judges determine which deck the players like the most, but not necessarily be the final decision.</p>
	</div>
	<table class="even divider hover border">
		<thead class="">
			<tr class="">
				<td class="">Votes</td>
				<td class="">Title</td>
				<td class="">Category</td>
			</tr>
		</thead>
		
		
		
		<tbody id="table_content">
		<?php 	
			$query = $db->prepare("SELECT * FROM competition ORDER BY deck_category, deck_vote DESC, deck_time DESC");
			$query->execute();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
		?>
	
		
			<tr class="">
				<td class=""><?= $row['deck_vote'] ?></td>
				<td class=""><a href="view.php?deck=<?= $row['id'] ?>" class=""><?= $row['deck_title'] ?></a></td>
				<td class="">
				
				<?php $cat = explode("/",$row['deck_category']); 
				
					for ($i = 0; $i < count($cat); $i++) {
						echo("<i class='icon-".$cat[$i]."'></i> ");
					}				
				?>
				
				</td>
			</tr>
				
		<?php } ?>
		
		</tbody>
	</table>
	</div>
	<div style="margin-top: 40px;" class="row">
		<div class="col-12" style="padding: 50px;"></div>
	</div>
</div>
</body>
</html>