<?php 
	include('admin/mysql/connect.php');
	include_once('admin/mysql/function.php');
	include_once('admin/mysql/deck.php');
	$x = new xClass();
	$deckData = new deck();
	
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}
	
	if (!isset($_SESSION['username'])) {
		header("location: ".$main."login.php?re=/my/decks");
	}
	

	$query = $db->prepare("SELECT * FROM decks WHERE deck_author = :user");
	$arr = array(
			'user' => $_SESSION['username']
		);
	$x->arrayBinder($query, $arr);
	
	$query->execute();
		
		
		
 ?>

<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolldier.com - Decks</title>
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
	<script src="<?php echo($main) ?>jquery.js"></script>
</head>
<body>

	<?php include('inc_/menu.php') ?>
		<div class="container">
			
			
			<div class="decks div-margin">
			
			


				<table>
					<tr class="modern">
						<td><i class="icon-star"></i> </td>
						<td width="300px">Deck title</td>
						<td width="120px"><i class="icon-growth"></i><i class="icon-decay"></i><i class="icon-order"></i><i class="icon-energy"></i></td>
						<td width="50px">Scrolls</td>
						<td>Version</td>
						<td>Author</td>	
						<td><i class="icon-comment"></i></td>
						<td>Age</td>
					</tr>
					<?php while ($deck = $query->fetch(PDO::FETCH_ASSOC)) { ?>
					
					<?php if ($deck['isHidden'] == 0) { ?>
					
					<tr>
						
						<td class="align-center"><?php echo($deck['vote']) ?></td>
						<td><a href="<?php echo($main) ?>deck/<?php echo($deck['id']) ?>"><?php echo($deck['deck_title']) ?></a></td>
						<td>
							<?php if ($deck['growth'] == 1) {
								echo('<i class="icon-growth"></i>');
							}
							
							if ($deck['decay'] == 1) {
								echo('<i class="icon-decay"></i>');
							}
							
							if ($deck['tOrder'] == 1) {
								echo('<i class="icon-order"></i>');
							}
							
							if ($deck['energy'] == 1) {
								echo('<i class="icon-energy"></i>');
							}
							
							if ($deck['wild'] == 1) {
								echo('<i class="icon-wild"></i>');
							}
							 ?>
						</td>
						<td><?php echo($deck['scrolls']) ?></td>
						<td><?php echo($deck['meta']) ?></td>
						<td><?php echo($deck['deck_author']) ?></td>	
						<td><?php echo($x->totalComments($deck['id'], 2)) ?></td>
						<td><?php echo($x->ago($deck['time'])) ?></td>
					</tr>
					<?php } else { ?>
						<?php if ($deck['deck_author'] == $_SESSION['username']) { ?>
							<tr class="isHidden" onclick="location.href='<?php echo($main) ?>deck/<?php echo($deck['id']) ?>'" style="cursor: pointer;">
								
								<td class="align-center"><?php echo($deck['vote']) ?></td>
								<td><?php echo($deck['deck_title']) ?></td>
								<td>
									<?php if ($deck['growth'] == 1) {
										echo('<i class="icon-growth"></i>');
									}
									
									if ($deck['decay'] == 1) {
										echo('<i class="icon-decay"></i>');
									}
									
									if ($deck['tOrder'] == 1) {
										echo('<i class="icon-order"></i>');
									}
									
									if ($deck['energy'] == 1) {
										echo('<i class="icon-energy"></i>');
									}
									
									if ($deck['wild'] == 1) {
										echo('<i class="icon-wild"></i>');
									}
									 ?>
								</td>
								<td><?php echo($deck['scrolls']) ?></td>
								<td><?php echo($deck['meta']) ?></td>
								<td>You</td>	
								<td><?php echo($x->totalComments($deck['id'], 2)) ?></td>
								<td><?php echo($x->ago($deck['time'])) ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				<?php } ?>
				</table>
								
			</div>
		</div>
		
	<?php include("inc_/footer.php"); ?>
</body>
</html>