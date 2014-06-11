<?php 
	include('../admin/mysql/connect.php');
	include_once('../admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}
	if (!isset($_SESSION['username'])) {
		$actual_link = $_SERVER['REQUEST_URI'];
		header("location: ../login.php?re=".$actual_link);
	}
	
	
	
		if (empty($_GET['u'])) {
			$_GET['u'] = $_SESSION['username'];
		}
		
		
		$query = $db->prepare("SELECT * FROM accounts WHERE ign=:user");	
	
		$arr = array(
				'user' => $_GET['u']
			);
			

		$x->arrayBinder($query, $arr);
			
		$query->execute();
		
		$user = $query->fetch(PDO::FETCH_ASSOC);
		
	$scrolldierAccount = true;
if (empty($user['ign'])) {
	$user['ign'] = $_GET['u'];
	$scrolldierAccount = false;
}
	
if (isset($_POST['submitInvite'])) {
	$guildQu = $db->prepare("INSERT INTO notification (user_id, type, text, guild_id) VALUES (:name, 1, :text, :guild)");
	$arr = array(
			'name' => $_POST['name'],
			'text' => "You have been invited to join " . $_POST['gname'],
			'guild' => $_POST['gid']
		);
		
	$x->arrayBinder($guildQu, $arr);
	if ($guildQu->execute()) {
		$_GET['success'] = "User invited to your guild";
	}
}

	
//http://a.scrollsguide.com/player?name=orangee&achievements&fields=all&avatar
$url = "http://a.scrollsguide.com/player?name=".$user['ign']."&achievements&fields=all&avatar";
$json = file_get_contents($url);
$data = json_decode($json, TRUE);

if ($data['msg'] == "success") { 

   $achieves = "../achievements.json";
   $json = file_get_contents($achieves);
   $achiv = json_decode($json, TRUE);
   
 } 
//    if (!isset($_GET['days']) || empty($_GET['days'])) {
//    	$_GET['days'] = 30;
//    }
//    if ($_GET['days'] > 30) {
//    	$_GET['days'] = 30;
//    }
//    if (!isset($_GET['graph'])) {
//    	$_GET['graph'] = "rating";
//    } else {
//    	$_GET['graph'] = lcfirst($_GET['graph']);
//    }
//    if ($_GET['graph'] == "gold" || $_GET['graph'] == "scrolls") {
//    	$graph = "http://a.scrollsguide.com/graph?name=".$_GET['name']."&days=".$_GET['days']."&type=".$_GET['graph'];
//    } else {
//    	$graph = "http://a.scrollsguide.com/graph?name=".$_GET['name']."&days=".$_GET['days'];
//    }
//		
//	$graph = file_get_contents($graph);
//	$graph = json_decode($graph, TRUE);

//$data['data']['achievements'][$j]['aID'] == $achiv['data'][$i]['id']

if ($data['msg'] == "success") { 	
$userAchives = array();

for ($i = 0; $i < count($data['data']['achievements']); $i++) {
	$id = $data['data']['achievements'][$i]['aID'];
	$time = $data['data']['achievements'][$i]['time'];
	
 	for ($j = 0; $j < count($achiv['data']); $j++) {
 	
 		if ($id == $achiv['data'][$j]['id']) {
 		
 		$name = $achiv['data'][$j]['name'];
 		$icon = $achiv['data'][$j]['icon'];
 		$desc = $achiv['data'][$j]['description'];
 		$gold = $achiv['data'][$j]['goldReward'];
 		
 		$pushArray = array(
 			"time" => $time,
 			"id" => $id,
 			"name" => $name,
 			"icon" => $icon,
 			"desc" => $desc,
 			"gold" => $gold
 		);
 		array_push($userAchives, $pushArray);
 		}
 	}
}

}
function getBadgeName($id) {
	$badgeNames = array("Adventurer", "Adept", "Trickster", "Sorcerer", "Apprentice Caller", "Caller", "Accomplished Caller", "Master Caller", "Exalted Caller", "Grand Master", "Aspect-Commander", "Ascendant");
	
	return $badgeNames[$id];
	
}

$userStats = array();




if ($data['msg'] == "success") {

$userStats['name'] = $data['data']['name'];
$userStats['rating'] = $data['data']['rating'];

$userStats['rank'] = $data['data']['rank'];
$userStats['badge'] = $data['data']['badgerank'];
$userStats['played'] = $data['data']['played'];
$userStats['ranked'] = $data['data']['rankedwon'];
$userStats['judgment'] = $data['data']['limitedwon'];
$userStats['won'] = $data['data']['won'];
$userStats['surrendered'] = $data['data']['surrendered'];
$userStats['gold'] = $data['data']['gold'];
$userStats['scrolls'] = $data['data']['scrolls'];
$userStats['lastgame'] = $data['data']['lastgame'];
$userStats['lastupdate'] = $data['data']['lastupdate'];


if ($data['data']['rating'] > 1500) {
	$userStats['decay'] = intval((($data['data']['rating']) - 1500)*0.05);
} else {
	$userStats['decay'] = 0;
}

$userStats['lost'] = ($userStats['played'] - $userStats['won'] - $userStats['surrendered']);



$userStats['ratio'] = round($userStats['won'] / $userStats['played'] * 100, 1);
	
}

//"rating":1635,"rank":184,"badgerank":7,"played":1307,"rankedwon":175,"limitedwon":56,"won":689,"surrendered":0,"gold":48283,"scrolls":1160,"lastgame":383197,"lastupdate":37597
		
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo($user['ign']) ?> - Scrolldier.com</title>
	<link rel="icon" type="image/png" href="<?php echo($main) ?>img/bunny.png">	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
</head>
<body>
	<?php include('../inc_/menu.php') ?>
	<?php $userGuild = $x->getGuild($user['ign']) ?>
	
	<div class="body" id="blog">
		<div class="container">
			<div class="wall_small">
				<div class="div-4 modern">
					
					<div class="div-center">
						<?php if (!$x->hasGuild($user['ign'])) { ?>
							<img src="<?php echo($userGuild['badge_url']) ?>" style="max-width: 22px; margin-right: 5px;" class="left" alt="" />
						<?php } ?>
						<h1 class="left"><?php echo($user['ign']) ?></h1>
						
					</div>
					
				</div>
				<div class="div-4">
					<?php if ($scrolldierAccount == false) { ?>
						<p class="align-center"><?php echo($user['ign']) ?> does not have an account on scrolldier</p>
					<?php } else { ?>
						<div class="avatar">
							<img src="<?php echo($main) ?>resources/head_<?php echo($user['headID']) ?>.png" width="400px" style="margin-left: -50px; margin-top: -20px;" alt="" />
						</div>
					<?php } ?>
					
				</div>
				
				<div class="div-4">
					<p>Embed Profile (html)</p>
					<textarea readonly="readonly" class="exportBox"><a href="http://scrolldier.com/user/<?php echo($user['ign']) ?>"><img src="http://scrolldier.com/userImage/<?php echo($user['ign']) ?>" alt="<?php echo($user['ign']) ?>'s Profile" /></a></textarea>
				</div>			
				
				<!--if ($data['data']['achievements'][$j]['aID'] == $achiv['data'][$i]['id']) {-->
				<?php if ($data['msg'] == "success") { ?>
				<div class="div-4">
					<h1 class="left modern div-4">Achievements (<?php echo(count($userAchives)) ?>/<?php echo(count($achiv['data'])) ?>)</h1>
					<div class="div-4 achives">
						<ul>
							<?php if ($achiv['msg'] == 'success') { ?>
								<?php for ($j = 0; $j < count($userAchives); $j++) {  ?>
										<li>
											<div class="div-4">
												<div class="span-achive">
													
													<img height="48px" style="margin-top: -6px;" src="<?php echo($main) ?>img/<?php echo($userAchives[$j]['icon']) ?>" alt="" />
												</div>
												<div class="span-achive-text">
													<h4><?php echo($userAchives[$j]['name']) ?></h4>
													<p class="achive-text"><?php echo($userAchives[$j]['desc']) ?></p>
												</div>
											</div>		
										</li>
								<?php } ?>								
							<?php } ?>	
						</ul>
					</div>						
				</div>
			<?php } ?>

				
			</div>
			<div class="wall_big">
			
				<div class="div-4 modern">
					<h1 class="left">Statistics</h1>
					<?php if (isset($guild) && $guild['guild_leader'] == $_SESSION['username'] && $x->hasGuild($user['ign'])) { ?>
						<form method="post" action="">
							<small>
								<input type="hidden" name="name" value="<?php echo($user['ign']) ?>" />
								<input type="hidden" name="gid" value="<?php echo($x->getGuildID($_SESSION['username'])) ?>" />
								<input type="hidden" name="gname" value="<?php echo($guild['name']) ?>" />
								<input type="submit" name="submitInvite" class="modern btn-modern btn-pagina" value="Invite to <?php echo($guild['short_name']) ?>" />
							</small>
						</form>
					<?php } ?>
					<?php if (strtolower($_GET['u']) == strtolower($_SESSION['username'])) { ?>
						<small class="right modern btn-pagina"><a href="<?php echo($main) ?>edit/user">Edit Profile</a></small>
					<?php } ?>
				</div>

				<div class="div-4 align-center div-center">
			<?php if ($data['msg'] == "success") { ?>	
				<?php if ($userStats['badge'] != -1) { ?>
					<h3><?php echo(getBadgeName($userStats['badge'])) ?></h3>
					<img src="<?php echo($main) ?>resources/badges/<?php echo($userStats['badge']) ?>.png" width="340px" alt="" />
				<?php } ?>
				</div>	
			<?php } ?>
				
				<div class="div-4 div-margin">
					
				<?php if ($data['msg'] == "success") { ?>
					<div class="span-4">
						<h4 class="">Ranking data</h4>
						<div class="div-4">
							<ul class="span-4 color-gray">
								<li>Current Rating</li>
								<li>Rating Decay</li>
								<li>Rank</li>
							</ul>
							<ul class="span-3 align-right">
								<li><?php echo($userStats['rating']) ?></li>
								<li><?php echo($userStats['decay']) ?></li>
								<li><?php echo($userStats['rank']) ?></li>
							</ul>
						</div>
					</div>
				
					<div class="span-4">
						<h4 class="">Match data</h4>
						<div class="div-4">
							<ul class="span-4 color-gray">
								<li>Games played</li>
								<li>Games Won</li>
								<li>Games Lost</li>
								<li>Ranked Won</li>
								<li>Judgment Won</li>
								<!--<li>Last game</li>-->
							</ul>
							<ul class="span-3 align-right">
								<li><?php echo($userStats['played']) ?></li>
								<li><?php echo($userStats['won']) ?> (<?php echo($userStats['ratio']) ?>%)</li>
								<li><?php echo($userStats['lost']) ?></li>
								<li><?php echo($userStats['ranked']) ?></li>
								<li><?php echo($userStats['judgment']) ?></li>
								<!--<li>10min ago</li>-->
							</ul>
						</div>
					</div>
					
					
					<div class="span-4 clear">
						<h4 class="">General Data</h4>
						<div class="div-4">
							<ul class="span-4 color-gray">
								<li>Gold</li>
								<li>Scrolls</li>
								<li>Donor</li>
								<li>Guild</li>
							</ul>
							<ul class="span-3 align-right">
								<li><i class="icon-coin"></i> <?php echo($userStats['gold']) ?></li>
								<li><i class="icon-scrolls"></i> <?php echo($userStats['scrolls']) ?></li>
								<li><?php 
									if ($x->hasDonated($user['ign']) == 1) {
										echo("Yes");
									} else {
										echo("no :(");
									}
								 ?></li>
								<li>
								<?php if (!$x->hasGuild($user['ign'])) { ?>
									<a href="<?php echo($main) ?>guild/<?php echo($x->getGuildID2($user['ign'])) ?>"><?php echo($userGuild['short_name']) ?></a>
								<?php } else { ?>
									No
								<?php } ?>
								</li>
							</ul>
						</div>
					</div>
				<?php }  else { ?>
					<div class="div-4">
						<p>Unable to get User data</p>
					</div>
				<?php } ?>
				
					<div class="span-4">
						<h4 class="align-left">Trophies / Badges</h4>
						<div class="div-4">
							<?php $thisRank = $user['rank']; ?>
							<?php $thisUser = $user['ign']; ?>
							<?php $thisID = $user['id']; ?>
							<?php include("../inc_/icon.php") ?>
						</div>
					</div>
					<?php if ($query->rowCount() != 0) { ?>
					<div class="div-4">
					<h1 class="modern">Decks by <?php echo($user['ign']) ?></h1>
					<div class="decks">	
						<table>
							<tr>
								<td width="60px">Score</td>
								<td>Name</td>
								<td width="120px">Type</td>
							</tr>
							<?php 
							$query = $db->prepare("SELECT * FROM decks WHERE deck_author = :ign
												   ORDER BY isHidden DESC,
												   meta DESC, vote DESC,
												   time DESC");
							
							$arr = array(
									'ign' => $user['ign']
								);
							$x->arrayBinder($query, $arr);
							
							
							$query->execute();
							
							while ($deck = $query->fetch(PDO::FETCH_ASSOC)) { ?>
							
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
									</tr>
								<?php } ?>
							<?php } ?>
						<?php } ?>
						</table>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			
				
				<?php 
						
				$fan_query = $db->prepare("SELECT * FROM fanScrolls WHERE user=:ign");	
					
				$fan_arr = array(
						'ign' => $user['ign']
					);
				$x->arrayBinder($fan_query, $fan_arr);
					
				$fan_query->execute();
						
				?>
						
			<?php if ($fan_query->rowCount() != 0) { ?>
			<div class="div-4">
				<h3>Fan Art Made:</h3>
				<?php while ($fanScroll = $fan_query->fetch(PDO::FETCH_ASSOC)) { ?>
					<div class="span-2">
						<a href="<?php echo($main."fanart/".$fanScroll['link']); ?>">
						<img src="<?php echo($fanScroll['parma_link']); ?>" class="div-4" alt="" />
						</a>
					</div>
				<?php }  ?>
				</div>
			<?php } ?>
			
		</div>
	</div>
<?php include("../inc_/footer.php"); ?>
<script src="../jquery.js"></script>
<script>
	$(function() {
		var time = <?php echo(count($userAchives) * 1.5) ?>;
		var timeout = time * 1000;
		var stop = 5000;
		var height = $(".achives")[0].scrollHeight;
		
		scrollsDown();
		
		function scrollsDown() {
			$( ".achives" ).animate({ scrollTop: height }, timeout, "linear", function() { 
				setTimeout(function() {
					scrollsUp(); 
				}, stop);
			});
		}
		function scrollsUp() {
			$( ".achives" ).animate({ scrollTop: 0 }, timeout, "linear", function() {
				setTimeout(function() {
					scrollsDown(); 
				}, stop);
			});
		}
		
	
	});
</script>
</body>
</html>