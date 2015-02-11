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
	
		<?php 	
			$query = $db->prepare("SELECT * FROM competition ORDER BY deck_category, deck_vote DESC, deck_time DESC");
			$query->execute();
			
			$exportJSON = [];
			
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			
			$data = (array)$deck->get_deck_data($row['deck_id']);

			unset($data['scrolls']);
			unset($data['author']);
			unset($data['curve']);
			unset($data['types']);
			unset($data['vote_up']);
			unset($data['vote_down']);
			unset($data['image']);
			unset($data['meta_version']);
			unset($data['percentage']);
			unset($data['time']);
			unset($data['text']);
			unset($data['faction']);
			unset($data['total_cost']);
			unset($data['tags']);
			
			
			
			$singleSubmission = array(
				'deck_title' => $row['deck_title'],
				//'author' => $row['deck_author'],
				'votes' => $row['deck_vote'],
				'category' => $row['deck_category'],
				'scrolldier_deck_id' => $row['deck_id'],
				'text' => $row['deck_desc'],
				'data' => $data
			);
			
			array_push($exportJSON, $singleSubmission);
			
		 } 
		 ?>
		 
			<pre><?= json_encode($exportJSON) ?></pre>
		 
		 
		 
	
</div>
</body>
</html>