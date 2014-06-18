
<input list="player" name="player" class="textbox span-4" value="<?php if (isset($_GET['player']) && !empty($_GET['player'])) { echo($_GET['player']); } ?>" placeholder="In game name">
<datalist id="player">
	<?php 
		$query = $db->prepare("SELECT ign FROM accounts WHERE guild = 0");
		$query->execute();
	
		while ($player = $query->fetch(PDO::FETCH_ASSOC)) {
		echo("<option value='".$player['ign']."'>");
			
	} ?>
</datalist>