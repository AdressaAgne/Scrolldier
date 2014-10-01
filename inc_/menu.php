
<?php include_once("analytics.php"); ?>
<?php $thisPage = $_SERVER['PHP_SELF']; 
//
//if (!isset($_SESSION['username'])) {
//
//	if (isset($_COOKIE['remember_user'])) {
//	
//		if (isset($_COOKIE['scrolldier_usernmae'])) {
//			
//			if (isset($_COOKIE['scrolldier_password'])) {
//				$login = $x->login($_COOKIE['scrolldier_usernmae'], $_COOKIE['scrolldier_password']);
//			}
//			
//		}
//			
//	}	
//}
?>
	<div class="wallpaper"></div>
	<div class="logo" onclick="location.href='<?php echo($main) ?>'"></div>

<div class="container clearfix">
		<div class="menu" <?php if (isset($_SESSION['username'])) {
			echo("style='margin-top: 22px;'");
		} ?>>
		<ul>

			<li <?php if ($thisPage == "/index.php") { echo(" class='active'"); }?>><a href="<?php echo($main) ?>"><img src="/img/menu/home.png" alt="" /></a></a></li>
			
	
			<li <?php if ($thisPage == "/deck.php") { echo(" class='active'"); }?>><a href="<?php echo($main) ?>decks/1/"><img src="/img/menu/decks.png" alt="" /></a>
				<ul class="sub">
				<?php if (isset($_SESSION['username'])) { ?>
					
					<li><a class="sub-menu" href="<?php echo($main) ?>my/decks">My decks</a></li>
					<li><a class="sub-menu" href="<?php echo($main) ?>my/favorites">Favorite Decks</a></li>
				<?php } ?>
					<li><a class="sub-menu" href="<?php echo($main) ?>new/deck">New deck</a></li>
					<li><a class="sub-menu" href="<?php echo($main) ?>deckbuilder/">Deckbuilder</a></li>
					<li><a class="sub-menu" href="<?php echo($main) ?>decks-in-the-last-day">Last 24 hours</a></li>
				</ul>
			</li>

		
			<li <?php if ($thisPage == "/guild.php") { echo(" class='active'"); }?>><a href="<?php echo($main) ?>guilds"><img src="/img/menu/guilds.png" alt="" /></a></li>


			<li <?php if ($thisPage == "/library.php") { echo(" class='active'"); }?>><a href="<?php echo($main) ?>scroll/library/"><img src="/img/menu/scrolls.png" alt="" /></a>
				<ul class="sub">
				<?php if (isset($_SESSION['username'])) { ?>
					<li><a class="sub-menu" href="<?php echo($main) ?>scroll/designer">New Scroll</a></li>
				<?php } ?>
					<li><a class="sub-menu" href="<?php echo($main) ?>scrolllib">In-Game</a></li>
					<li><a class="sub-menu" href="<?php echo($main) ?>missing">Your Collection</a></li>
				</ul>
			</li>
			
		</ul>
		
		
	</div>
	
	<?php if (isset($_SESSION['username'])) { ?>
	<div class="logout">
		<div class="right"><a class="modern" href="<?php echo($main) ?>logout">logout</a></div>
	<?php if ($_SESSION['rank'] == 1) { ?>
		<div class="left"><a class="modern" href="<?php echo($main) ?>admin.php">Admin</a></div>
	<?php } elseif ($_SESSION['rank'] == 2) { ?>
		<div class="left"><a class="modern" href="<?php echo($main) ?>admin.php">Mod</a></div>
	<?php } elseif ($_SESSION['rank'] == 5) { ?>
		<div class="left"><span class="modern">Mojang</span></div>
	<?php } ?>
	
	<?php if ($x->hasDonated($_SESSION['username'])) { ?>
		<div class="left"><span class="modern">Donator</a></div>
	<?php } ?>
	
		<?php $notfiCount = $x->notfiCount($_SESSION['username']); ?>
		<div class="left"><a class="modern" href="<?php echo($main) ?>inbox/main">Inbox<?php if ($notfiCount == 0) {
		} else {
			echo("<i class='icon-round'></i>");
		}?></a></div>
		
		<?php if (!$x->hasGuild($_SESSION['username'])) { ?>
			<?php $guild = $x->getGuild($_SESSION['username']) ?>
			<div class="left"><a class="modern" href="<?php echo($main) ?>guild/<?php echo($x->getGuildID2($_SESSION['username'])) ?>"><?php echo($guild['short_name']) ?></a></div>	
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
					
					<?php if (file_exists('resources/head_'.$_SESSION['headID'].'.png') || file_exists('../resources/head_'.$_SESSION['headID'].'.png')) { ?>
						<?php if ($_SESSION['headID'] == 194) { ?>
							<img style="margin-top: 15px;" src="<?php echo($main) ?>resources/head_<?php echo($_SESSION['headID']) ?>.png" width="200px" alt="" />
						<?php } else { ?>
							<img src="<?php echo($main) ?>resources/head_<?php echo($_SESSION['headID']) ?>.png" width="200px" alt="" />
						<?php } ?>
						
					<?php } else {
						$_GET['w'] = 'Could not find in game head! Contact <a href="mailto:support@scrolldier.com">support@scrolldier.com</a> for help';
					 } ?>
				</div>
				
				<li style="width: 101%;" class="user-name"><a href="<?php echo($main) ?>user"><?php echo($_SESSION['username']) ?></a></li>
			</ul>
		<?php } else { ?>
			<ul>
			<?php $actual_link = $_SERVER['REQUEST_URI']; ?>
				<li style="width: 50%;"><a href="<?php echo($main) ?>login.php?re=<?php echo($actual_link) ?>"><img src="/img/menu/login.png" alt="" /></a></li>
				<li style="width: 51%;"><a href="<?php echo($main) ?>u/reg.php"><img src="/img/menu/signup.png" alt="" /></a></li>
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
