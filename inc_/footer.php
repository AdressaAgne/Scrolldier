<?php $linkPre = ""; ?>
<div class="footer" id="footer">
	<div class="container clearfix">
		<div class="div-2 div-margin">
			<h4>Thanks to</h4>
			<ul>
				<li><a href="http://mojang.com" target="_blank">Mojang</a></li>
				<li><a href="http://scrolls.com" target="_blank">Scrolls</a></li>
				<li><a href="http://a.scrollsguide.com" target="_blank">Scrollsguide API</a></li>
				<li><a href="<?php echo($main."user/kbasten") ?>">kBasten</a></li>
				<li><a href="<?php echo($main."user/cradstache") ?>">cradstache</a></li>
			</ul>
		</div>
		<div class="div-2 div-margin">
			<h4>Links</h4>
			<ul>
				<li><a href="http://scrollsguide.com" target="_blank">Scrollsguide</a></li>
				<li><a href="http://scrollsdev.tumblr.com/" target="_blank">Scrolls Dev Blog</a></li>
				<li><a href="http://academy.scrollsguide.com/" target="_blank">SG Academy</a></li>
				<li><a href="http://scrollstoolbox.com/" target="_blank">ScrollsToolbox</a></li>
				<li><a href="http://theyseemescrollin.com/" target="_blank">They See Me scrollin</a></li>
				<li><a href="http://reddit.com/r/scrolls" target="_blank">/r/scrolls</a></li>
				<li><a href="http://alpha.scrolldier.com" target="_blank">Scrolldier Dev</a></li>
			</ul>
		</div>
		<div class="div-2 div-margin">
			<h4>Shortcuts</h4>
			<ul>
				<li><a href="<?php echo($main) ?>login.php">Login</a></li>
				<li><a href="<?php echo($main) ?>">Home</a></li>
				<li><a href="<?php echo($main) ?>decks">Decks</a></li>
				<li><a href="<?php echo($main) ?>guilds">Guilds</a></li>
				<li><a href="<?php echo($main) ?>scrolls.php">Scrolls</a></li>
				<li><a href="<?php echo($main) ?>tile.php">Tiles</a></li>
				<li><a href="<?php echo($main) ?>audio.php">Audio</a></li>
			</ul>
		</div>
		<div class="div-1 div-margin">
			<h4>Contact</h4>
				<ul>
					<li>Support: <a href="mailto:support@scrolldier.com" target="_blank">support@scrolldier.com</a></li>
					<li>Contact: <a href="mailto:contact@scrolldier.com" target="_blank">contact@scrolldier.com</a></li>
					<li>Creator: <a href="mailto:orangee@scrolldier.com" target="_blank">orangee@scrolldier.com</a></li>
					<li class="clearfix"><p class="left">Wanna Help us?</p>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" class="left">
							<input type="hidden" name="cmd" value="_donations">
							<input type="hidden" name="business" value="agne240@me.com">
							<input type="hidden" name="lc" value="US">
							<input type="hidden" name="item_name" value="Orangee">
							<input type="hidden" name="no_note" value="0">
							<input type="hidden" name="currency_code" value="EUR">
							<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
							<input type="submit" class="btn-modern" name="" value="Donate" />
						</form>
					</li>
					<li><a href="https://twitter.com/Agne240" class="twitter-follow-button" data-show-count="false">Follow @Agne240</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li>
				</ul>
		</div>
		<div class="div-4">
			<p class="align-center">Scrolldier.com is still in beta, and things may not work</p>
			<p class="align-center">Need help or got questions? send a mail, or ask on IRC: irc.esper.net - #scrolldier</p>
			
			
			
			<p class="align-center">© Scrolldier.com 2014</p>
		</div>
	</div>
</div>
<script src="<?php echo($main) ?>jquery.js"></script>
<script>

$(function() {

	var r = Math.floor((Math.random() * 3));

	switch (r) {
		case 0:
			s = "decay";
			break;
		case 1:
			s = "energy";
			break;
		case 2:
			s = "order";
			break;
		case 3:
			s = "growth";
			break;
		
	}
	
	$("body").addClass(s);

});

</script>