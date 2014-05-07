<div class="header">
	<?php if ($page <= 1) { ?>
		<a class="btn-pagina modern" href="?p=2">Older</a>		
	<?php } else if ($page > 1) { ?>
		<a class="btn-pagina modern" href="?p=<?php echo($page-1) ?>">Newer</a>

		<a class="btn-pagina modern" href="?p=<?php echo($page+1) ?>">Older</a>		
	<?php } ?>
</div>