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
	<?php 
		
		
		$pageSize = 5;
		
		if (!isset($_GET['page']) || empty($_GET['page'])) {
			$page = 1;
		} else {
			$page = intval($_GET['page']);
		}
		
		$stop = $pageSize;
		
		$start = ($page-1) * $pageSize;
		
		if ($start < 0) {
			$start = 0;
		}
		
		$ressource = "";
		
		if (isset($_GET['growth'])) {
			$ressource .= " AND growth = 1";
		}
		if (isset($_GET['order'])) {
			$ressource .= " AND tOrder = 1";
		}
		if (isset($_GET['energy'])) {
			$ressource .= " AND energy = 1";
		}
		if (isset($_GET['decay'])) {
			$ressource .= " AND decay = 1";
		}
		if (isset($_GET['wild'])) {
			$ressource .= " AND wild = 1";
		}
		
		if (isset($_GET['search']) && !empty($_GET['search'])) {
			$query = $db->prepare("SELECT * FROM decks
								   WHERE (deck_title LIKE :search OR deck_author LIKE :search ) ".$ressource."
								   ORDER BY isHidden DESC,
								   meta DESC, vote DESC,
								   time DESC LIMIT :limitStart, :limitEnd");
			$arr = array(
					'search' => "%".$_GET['search']."%"
				);
			$x->arrayBinder($query, $arr);
			
		} else {
		
			$query = $db->prepare("SELECT * FROM decks
								   ORDER BY isHidden DESC,
								   meta DESC, vote DESC,
								   time DESC LIMIT :limitStart, :limitEnd");
		}
		
		
		$arr = array(
				'limitStart' => $start,
				'limitEnd' => $stop,
			);
		$x->arrayBinderInt($query, $arr);
		
		
		$query->execute();
	 ?>
		<div class="container">
			
				
			
			<div class="decks div-margin">
			
		
			
				<div class="searchbox">
					<form method="post" action="" class="">
						<div class="chooseBox clearfix">
							<div class="checkbox">
								<form method="post" action="">
								<ul class="left">
									<?php if (isset($_SESSION['username'])) { ?>
									<li class="left">
										<a class="btn-modern btn-pagina btn-no-margin" href="<?php echo($main) ?>new/deck">New Deck</a><br />
									</li>
									<?php } ?>
								</ul>
							
								<ul class="right">
								 <li>
								 	<input type="search" name="search_box" id="searchTextBox" class="searchText" value="" placeholder="Search..."/>
								 </li>
								 <li>
								 	<input type="submit" name="submit" value="Search" class="btn-modern btn-pagina searchButton" />
								 </li>
								</ul>
								
								<ul class="right typeIcons">
								  <li>
								      <input id="order_checkbox2" type="checkbox" checked="checked" name="type_order" value="">
								      <label class="checkbox" for="order_checkbox2"><i class="icon-order"></i></label> 
								      
								  </li>
								  <li>  
								      <input id="energy_checkbox2" type="checkbox" checked="checked" name="type_energy" value="">
								      <label class="checkbox" for="energy_checkbox2"><i class="icon-energy"></i></label> 
								     
								  </li>
								  <li>
								      <input id="growth_checkbox2" type="checkbox" checked="checked" name="type_growth" value="">
								      <label class="checkbox" for="growth_checkbox2"><i class="icon-growth"></i></label> 
								  </li>
								 <li class="">
								     <input id="decay_checkbox2" type="checkbox" checked="checked" name="type_decay" value="">
								     <label class="checkbox" class="" for="decay_checkbox2"><i class="icon-decay"></i></label> 
								 </li>
								 <li class="">
								     <input id="wild_checkbox2" type="checkbox" checked="checked" name="type_wild" value="">
								     <label class="checkbox" class="" for="wild_checkbox2"><i class="icon-wild"></i></label> 
								 </li>
								 </ul>
								</form>
							</div>
						</div>
						
					</form>
				</div>
				<table>
					<tr class="modern">
						<td><a href="?orderBy=vote">Score</a></td>
						<td width="300px"><a href="?orderBy=name">Name</a></td>
						<td width="120px"><a href="?orderBy=type">Type</a></td>
						<td width="50px"><a href="?orderBy=scrolls">Scrolls</a></td>
						<td>Version</td>
						<td width=""><a href="?orderBy=author">Author</a></td>	
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
	<script>
		$(function(){
			$("#searchTextBox").focus(function(){
				$(this).css("width", "200px");
			});
			$("#searchTextBox").focusout(function(){
				if ($("#searchTextBox").val() == "") {
					$(this).css("width", "70px");
				}
			});
		});
	</script>
</body>
</html>