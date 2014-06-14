<?php 
	include('admin/mysql/connect.php');
	include_once('admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}
	
	


		
		$query = $db->prepare("SELECT * FROM decks WHERE isHidden = 0 AND time >= now() - INTERVAL 1 DAY
							   ORDER BY time DESC");

		$x->arrayBinderInt($query, $arr);
		
		
		$query->execute();
		
		
		$totalDecks = $query->rowCount();
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
			
			
			

				<p>Total decks: <?php echo($totalDecks); ?></p>

			
				<div class="searchbox">

						<ul class="left">
							<?php if (isset($_SESSION['username'])) { ?>
							<li class="left">
								<a class="btn-modern btn-pagina btn-no-margin" href="<?php echo($main) ?>new/deck">New Deck</a><br />
							</li>
							<?php } ?>
							<li class="left">
								<a class="btn-modern btn-pagina btn-no-margin" href="<?php echo($main) ?>decks/1/">Back</a><br />
							</li>
						</ul>

				</div>
				<table>
					<tr class="modern">
						<td>Score</td>
						<td width="300px">Name</td>
						<td width="120px">Type</td>
						<td width="50px">Scrolls</td>
						<td>Version</td>
						<td>Author</td>	
						<td>Comments</td>
						<td>Age</td>
					</tr>
					<?php while ($deck = $query->fetch(PDO::FETCH_ASSOC)) { ?>
					
					<?php if ($deck['isHidden'] == 0) { ?>
					
					<tr onclick="location.href='<?php echo($main) ?>deck/<?php echo($deck['id']) ?>'" style="cursor: pointer;">
						
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