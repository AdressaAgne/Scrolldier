<?php include_once("analytics.php"); ?>
<?php $thisPage = $_SERVER['PHP_SELF']; ?>
<?php if ($thisPage == "/u/index.php" || $thisPage == "/u/edit.php") { ?>
	<div class="logo" onclick="location.href='../index.php'"></div>
<?php } else { ?>
	<div class="logo" onclick="location.href='index.php'"></div>
<?php } ?>


<div class="container clearfix">
	
	<?php if (isset($_SESSION['username'])) { ?>
		<div class="menu" style="margin-top: 22px;">
	<?php } else { ?>
		<div class="menu">
	<?php }?>
	
		<?php if ($thisPage == "/u/index.php" || $thisPage == "/u/edit.php" || $thisPage == "/guild/index.php" || $thisPage == "/guild/g.php" || $thisPage == "/guild/edit.php") {
			$prepend = "../";
		} else {
			$prepend = "";
		 } ?>	
				<ul>
					<?php if ($thisPage == "/index.php") { ?>
						<li class="active"><a href="<?php echo($prepend) ?>index.php">Home</a></li>
					<?php } else { ?>
						<li><a href="<?php echo($prepend) ?>index.php">Home</a></li>
					<?php } ?>
					
					
					<?php if ($thisPage == "/deck.php") { ?>
						<li class="active"><a href="<?php echo($prepend) ?>deck.php">Decks</a></li>
					<?php } else { ?>
						<li><a href="<?php echo($prepend) ?>deck.php">Decks</a></li>
					<?php } ?>
					
					<?php if ($thisPage == "/guild.php") { ?>
						<li class="active"><a href="<?php echo($prepend) ?>guild.php">Guilds</a></li>
					<?php } else { ?>
						<li><a href="<?php echo($prepend) ?>guild.php">Guilds</a></li>
					<?php } ?>
					
					
					<?php if (isset($_SESSION['username']) && $_SESSION['rank'] <= 2) { ?>
						<?php if ($thisPage == "/new_spoiler.php") { ?>
							<li class="active"><a href="<?php echo($prepend) ?>new_spoiler.php">New Spoiler</a></li>
						<?php } else { ?>
							<li><a href="<?php echo($prepend) ?>new_spoiler.php">New Spoiler</a></li>
						<?php } ?>
					<?php } ?>
					
					
					<?php if ($thisPage == "/feedback.php") { ?>
						<li class="active"><a href="<?php echo($prepend) ?>feedback.php">Feedback</a></li>
					<?php } else { ?>
						<li><a href="<?php echo($prepend) ?>feedback.php">Feedback</a></li>
					<?php } ?>
				</ul>
		
		
	</div>
	
	<?php if (isset($_SESSION['username'])) { ?>
		<div class="logout">
	<div class="right"><a class="modern" href="?logout">logout</a></div>
	
		
	 
	
	<?php if ($_SESSION['rank'] == 1) { ?>
		<div class="left"><a class="modern" href="<?php echo($prepend) ?>admin.php">Admin</a></div>
	<?php } elseif ($_SESSION['rank'] == 2) { ?>
		<div class="left"><a class="modern" href="<?php echo($prepend) ?>admin.php">Mod</a></div>
	<?php } elseif ($_SESSION['rank'] == 5) { ?>
		<div class="left"><span class="modern">Mojang</span></div>
	<?php } ?>
	
	<?php if ($x->hasDonated($_SESSION['username'])) { ?>
		<div class="left"><span class="modern">Donator</a></div>
	<?php } ?>
	
		<?php $notfiCount = $x->notfiCount($_SESSION['username']); ?>
		<div class="left"><a class="modern" href="<?php echo($prepend) ?>inbox.php">Inbox<?php if ($notfiCount == 0) {
			echo("<i class='icon-round disabled'></i>");
		} else {
			echo("<i class='icon-round'></i>");
		}?></a></div>
		
		<?php if (!$x->hasGuild($_SESSION['username'])) { ?>
			<?php $guild = $x->getGuild($_SESSION['username']) ?>
			<div class="left"><a class="modern" href="<?php echo($prepend) ?>guild/g.php?g=<?php echo($x->getGuildID2($_SESSION['username'])) ?>"><?php echo($guild['short_name']) ?></a></div>	
		<?php } ?>
		
		</div>
	<?php } ?>
	
	
	<?php if ($thisPage == "/u/index.php" || $thisPage == "/u/edit.php") { ?>
		<div class="menu menu-login active">
	<?php } else { ?>
		<div class="menu menu-login">
	<?php } ?>
	
		<?php if (isset($_SESSION['username'])) { ?>
			<ul>
				<div class="avatar">
					
					<?php if (file_exists('resources/head_'.$_SESSION['headID'].'.png')) { ?>
						<img src="resources/head_<?php echo($_SESSION['headID']) ?>.png" width="200px" alt="" />
					<?php } elseif (file_exists('../resources/head_'.$_SESSION['headID'].'.png')) { ?>
						<img src="../resources/head_<?php echo($_SESSION['headID']) ?>.png" width="200px" alt="" />
					<?php } else {
						$_GET['w'] = 'Could not find in game head! Contact <a href="mailto:support@scrolldier.com">support@scrolldier.com</a> for help';
					 } ?>
				</div>
				<?php if ($thisPage == "/u/index.php" || $thisPage == "/u/edit.php") { ?>
					<li><a href="<?php echo($prepend) ?>index.php"><?php echo($_SESSION['username']) ?></a></li>
				<?php } else { ?>
					<li><a href="<?php echo($prepend) ?>u/"><?php echo($_SESSION['username']) ?></a></li>
				<?php } ?>
			</ul>
		<?php } else { ?>
			<ul>
				<li><a href="login.php?re=<?php echo($_SERVER['PHP_SELF']) ?>">Login</a></li>
				<li><a href="u/reg.php">Sign up</a></li>
			</ul>
		<?php } ?>
	</div>
		<!--<div class="menu menu-login right">
		<ul class="">
			<li>
				<form method="post" action="">
					<input type="text" class="textbox full" name="search" value="" placeholder="Search..."/>
				</form>
			</li>
		</ul>
		</div>-->
</div>
<?php if (isset($_GET['w']) && !empty($_GET['w'])) { ?>
	<div class="container">
		<div class="modern last"><?php echo($_GET['w']) ?></div>
	</div>
<?php } ?>
