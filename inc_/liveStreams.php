<?php 
	if (!isset($_GET['streamGame']) && empty($_GET['streamGame'])) {
		$_GET['streamGame'] = 'Scrolls';
	}

	$streams = "https://api.twitch.tv/kraken/streams?game=".$_GET['streamGame']."&limit=4";
	$streams = file_get_contents($streams);
	$streams = json_decode($streams, TRUE);
	
	
 ?>
  <?php if (!empty($streams['streams'])) { ?>
 <div style="width: 605px; float: left;">
 	<h3 style="text-align: left !important;"><img style="margin-right: 10px;" src="<?php echo($streams['streams'][0]['channel']['logo']) ?>" height="30" alt="" /><?php echo($streams['streams'][0]['channel']['display_name']) ?></h3>
 	 <p><?php echo($streams['streams'][0]['channel']['status']) ?></p>
 	 
 	<object type="application/x-shockwave-flash" height="365" width="600" id="live_embed_player_flash" data="http://www.twitch.tv/widgets/live_embed_player.swf?channel=<?php echo($streams['streams'][0]['channel']['display_name']) ?>" bgcolor="#000000"><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" /><param name="flashvars" value="hostname=www.twitch.tv&channel=<?php echo($streams['streams'][0]['channel']['display_name']) ?>&auto_play=false&start_volume=25" /></object><a href="http://www.twitch.tv/<?php echo($streams['streams'][0]['channel']['display_name']) ?>" style="padding:2px 0px 4px; display:block; width:345px; font-weight:normal; font-size:10px;text-decoration:underline; text-align:center;"></a>
 	
 </div>

 <?php } ?>
   <?php if (!empty($streams['streams'])) { ?>
 <div class="news_wall">

	<div id="">
		<h2 class=""><?php echo($_GET['streamGame']) ?> Streams Online (<?php echo($streams['_total']) ?>)</h2>

		<?php for ($st = 1; $st < count($streams['streams']); $st++) { ?>
				<h2>
					<a href="<?php echo($streams['streams'][$st]['channel']['url']) ?>">
					<?php echo($streams['streams'][$st]['channel']['display_name']) ?>
					</a>
				</h2>
			<div class="modern clearfix frontStream">
				

				<div class="left clearfix status" style="clear: left;">
					<p class=""><?php echo(substr($streams['streams'][$st]['channel']['status'],0,41)) ?></p>
				</div>
				
				<div class="baseStats clearfix" style="clear: left;">
					<div class="left" style="margin-right: 10px;">
						<a href="<?php echo($streams['streams'][$st]['channel']['url']) ?>">
							<img src="<?php echo($streams['streams'][$st]['channel']['logo']) ?>" height="60" alt="" />
						</a>
					</div>
	
					<div class="left" style="width: 250px;">
						<div class="left">Currently Viewing</div>
						<div class="right" style="">
							<?php echo($streams['streams'][$st]['viewers']) ?>
						</div>
						
						<div class="left" style="clear: both;">Followers</div>
						<div class="right">
							<?php echo($streams['streams'][$st]['channel']['followers']) ?>
						</div>	
						
						<div class="left" style="clear: both;">Views</div>
						<div class="right">
							<?php echo($streams['streams'][$st]['channel']['views']) ?>
						</div>						
					</div>
				</div>
		</div>
	<?php } ?>
	</div>
<?php } ?>
</div>