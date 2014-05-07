<?php 
	include('admin/mysql/connect.php');
	include('admin/mysql/function.php');
	$x = new xClass();
	
	if (isset($_POST['submit']) && isset($_POST['mail']) && !empty($_POST['mail'])) {
		if ($x->betaSignup($_POST['mail'])) {
			header("location: ?thanks");
		}
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome Scrolldier</title>
	<link rel="stylesheet" href="css/master.css" />
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
</head>
<body class="main">
<!--	<div class="box2" style="margin-top: 20px;">
		<h4 class="align-center" style="margin-top: 30px; color: #fff; position: absolute; z-index: 3; width: 728px;">Ads keep the site alive</h4>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

		<ins class="adsbygoogle"
		     style="display:inline-block;width:728px;height:90px; z-index: 2;"
		     data-ad-client="ca-pub-2480986580065735"
		     data-ad-slot="2262573990"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div>-->
	
	
	<?php if (isset($_GET['thanks'])) { ?>
		<div class="narrowContainer">
			<h2>Thanks for contributing to the development of scrolldiers.com</h2>
		</div>
	<?php } else { ?>
		<div class="narrowContainer">
			<h2>This site is still under construction</h2>
			<h2>Starting beta testing soon</h2>
			<h2>May the owls be with you</h2>
			<br />
			<p>Basically this is a new fan site for scrolls, it will contain a user system, deck lists, a spoiler blog where all the spoilers from all the devs will be collected and brought to one place. Twitch Api, current online Twitch streams, a list of all streamers that stream scrolls on a regular base.</p>
			<br />
			<p>User search, search amongst all the in-game accounts of scrolls. look up gold, graphs, rating graphs, scrolls everything about a player.</p>
			<br />
			<p>The first months we will try a closed beta, when we get the core inn and some other stuff we will go to open beta.</p>
			
			<form method="post" class="betaSignup" action="">
				<h1>Sign up for the closed beta!</h1>
				<input type="email" id="mail" class="text" name="mail" value="" placeholder="Your mail" />
				<input type="submit" class="button" name="submit" value="Count me as a scrolldier" />
			</form>
			
		</div>
	<?php } ?>
			
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_donations">
			<input type="hidden" name="business" value="agne240@me.com">
			<input type="hidden" name="lc" value="US">
			<input type="hidden" name="item_name" value="Orangee">
			<input type="hidden" name="no_note" value="0">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
<script src="jquery.js" type="text/javascript"></script>
<script>
    $(function() {
    	
        var width = $(window).width();
        var height = $(window).height();
        function jqUpdateSize() {
           $("[class*=fullScreen]").css("height", (height-53) + "px");
           width = $(window).width();
           height = $(window).height();
        };
        
        jqUpdateSize()
        var resizeTimer;
        $(window).resize(function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(jqUpdateSize, 0);
        });
        
        
        //#autoScroll
        var scrollFrom = 0; 
        $('a[href*=#]').click(function(e){
            scrollFrom = $(window).scrollTop();
            $(window).scrollTop(scrollFrom);
            var target = '#' + $(this).attr("href").replace(/#/,'');
            if ($(this).attr("href") != "#myCarousel") {
        	    $('html,body').animate({
        	        scrollTop: $(target).offset().top // modification
        	    },{
        	     duration: 1000,
        	     easing: 'swing'
        	    });
        	     return false; 	
            }
        }); 
        
    });
</script>
</body>
</html>