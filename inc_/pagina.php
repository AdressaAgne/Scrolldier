<div class="deckPagina">
	<?php
	$totalPages = intval($totalPosts / $pageSize)+1;
		
		if ($page != 1) { ?>
		
		<a  class="btn-modern btn-pagina btn-no-margin" href="<?php echo($main) ?><?php echo(intval($page-1)) ?>">Newer</a>
		
	<?php	}
	
	if ($totalPages != 1) {
	 for ($i = 1; $i <= $totalPages; $i++) {
		
		
		if ($i != $page) { ?>
		
			<a  class="btn-modern btn-pagina btn-no-margin" href="<?php echo($main) ?><?php echo($i) ?>"><?php echo($i) ?></a>
			
			
		<?php }
		
		if ($i == $page) { ?>
		
			<a  class="btn-modern btn-pagina btn-no-margin active" href="<?php echo($main) ?><?php echo($i) ?>"><?php echo($i) ?></a>
								
		<?php }					
	} 
	} 
	
	if ($page != $totalPages) { ?>
		
		<a  class="btn-modern btn-pagina btn-no-margin" href="<?php echo($main) ?><?php echo(intval($page+1)) ?>">Older</a>
		
	<?php	}
	
	?>
</div>