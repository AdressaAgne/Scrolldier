<?php 
include('../../admin/mysql/connect.php');
include('../../admin/mysql/function.php');
include('../../admin/mysql/scrolls.php');
include('../../admin/mysql/deck.php');
$x = new xClass();
$scroll = new scrolls();
$deckData = new deck();

$query = $db->prepare("SELECT * FROM decks WHERE isHidden = 0 AND JSON LIKE '%\"id\":".$_POST['scroll'].",%' ORDER BY meta DESC, vote DESC, time DESC");



$query->execute(); ?>
<div class="library-info clearfix">
	<div class="div-4">
		<div class="decks div-margin libraryDecks">
		<button id="closeDeck" data-id="<?php echo($_POST['scroll']) ?>" class="btn-modern right">Back</button>
<table class="">
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
</div>