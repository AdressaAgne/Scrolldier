<?php 
include('admin/mysql/connect.php');
include('admin/mysql/function.php');
include('admin/mysql/badges.php');
$x = new xClass();
$badge = new badges();

session_start();
if (isset($_GET['logout'])) {
	$x->logout();
}
if (!isset($_SESSION['username'])) {
	header("location: login.php");
}



if(isset($_POST['submitScrolls']))  {


	
	if (isset($_POST['file'])) {
		$url = "admin/versions/".$_POST['vFile'];
	} else {
		$url = "http://a.scrollsguide.com/scrolls";
		
	}
	
	$json = file_get_contents($url);
	$data = json_decode($json, TRUE);
	
	if ($data['msg'] == "success" && !isset($_POST['file'])) { 
		$empty = $db->prepare("DELETE FROM scrollsCard");
		if ($empty->execute()) {
		for ($i = 0; $i < count($data['data']); $i++) {	
			
				
			$query = $db->prepare("INSERT INTO scrollsCard

			(id, name, description, kind, types, costgrowth, costorder, costenergy, costdecay, ap, ac, hp, flavor, rarity,
			 scrollsSet, targetarea, image, bundle, animationpreview, version, introduced,
			 passiverules_1, passiverules_2, passiverules_3,
			 anim_left, anim_top, anim_right, anim_bottom)
			
			 

			VALUES
			(:id, :name, :description, :kind, :types, :costgrowth, :costorder, :costenergy, :costdecay, :ap, :ac, :hp, :flavor, :rarity,
			:scrollsSet, :targetarea, :image, :bundle, :animationpreview, :version, :introduced,
			:passiverules_1, :passiverules_2, :passiverules_3,
			:anim_left, :anim_top, :anim_right, :anim_bottom)");
			
			if (isset($data['data'][$i]['passiverules'][0]['name'])) {
				$pass0 = $data['data'][$i]['passiverules'][0]['name'];
			} else {
				$pass0 = "";
			}
			if (isset($data['data'][$i]['passiverules'][1]['name'])) {
				$pass1 = $data['data'][$i]['passiverules'][1]['name'];
			} else {
				$pass1 = "";
			}
			if (isset($data['data'][$i]['passiverules'][2]['name'])) {
				$pass2 = $data['data'][$i]['passiverules'][2]['name'];
			} else {
				$pass2 = "";
			}
			
			if (isset($data['data'][$i]['anim']['left'])) {
				$anim0 = $data['data'][$i]['anim']['left'];
			} else {
				$anim0 = NULL;
			}
			if (isset($data['data'][$i]['anim']['right'])) {
				$anim2 = $data['data'][$i]['anim']['right'];
			} else {
				$anim2 = NULL;
			}
			if (isset($data['data'][$i]['anim']['top'])) {
				$anim1 = $data['data'][$i]['anim']['top'];
			} else {
				$anim1 = NULL;
			}
			if (isset($data['data'][$i]['anim']['bottom'])) {
				$anim3 = $data['data'][$i]['anim']['bottom'];
			} else {
				$anim3 = NULL;
			}
			
			
			$arr = array(
					'id' => $data['data'][$i]['id'],
					'name' => $data['data'][$i]['name'],
					'description' => $data['data'][$i]['description'],
					'kind' => $data['data'][$i]['kind'],
					'types' => $data['data'][$i]['types'],
					'costgrowth' => $data['data'][$i]['costgrowth'],
					'costorder' => $data['data'][$i]['costorder'],
					'costenergy' => $data['data'][$i]['costenergy'],
					'costdecay' => $data['data'][$i]['costdecay'],
					'ap' => $data['data'][$i]['ap'],
					'ac' => $data['data'][$i]['ac'],
					'hp' => $data['data'][$i]['hp'],
					'flavor' => $data['data'][$i]['flavor'],
					'rarity' => $data['data'][$i]['rarity'],
					'scrollsSet' => $data['data'][$i]['set'],
					'targetarea' => $data['data'][$i]['targetarea'],
					'image' => $data['data'][$i]['image'],
					'bundle' => $data['data'][$i]['bundle'],
					'animationpreview' => $data['data'][$i]['animationpreview'],
					'version' => $data['data'][$i]['version'],
					'introduced' => $data['data'][$i]['introduced'],
					'passiverules_1' => $pass0,
					'passiverules_2' => $pass1,
					'passiverules_3' => $pass2,
					'anim_left' => $anim0,
					'anim_top' => $anim1,
					'anim_right' => $anim2,
					'anim_bottom' => $anim3
				);
			
			$x->arrayBinder($query, $arr);
			
				if ($query->execute()) {
					
				}
		}
	}
	}
	
	if (isset($_POST['file'])) {

		 
				$empty = $db->prepare("DELETE FROM scrollsCard");
				
				if ($empty->execute()) {

					
					
//					echo("<pre>");
//					print_r($data);
//					echo("</pre>");
					
					
					
				
				
				for ($i = 0; $i < count($data['cardTypes']); $i++) {

					$query = $db->prepare("INSERT INTO scrollsCard
		
					(id, name, description, kind, types, costgrowth, costorder, costenergy, costdecay, ap, ac, hp, flavor, rarity,
					 scrollsSet, targetarea, image, bundle, animationpreview, version, introduced,
					 passiverules_1, passiverules_2, passiverules_3,
					 anim_left, anim_top, anim_right, anim_bottom, sound)
					
					 
		
					VALUES
					(:id, :name, :description, :kind, :types, :costgrowth, :costorder, :costenergy, :costdecay, :ap, :ac, :hp, :flavor, :rarity,
					:scrollsSet, :targetarea, :image, :bundle, :animationpreview, :version, :introduced,
					:passiverules_1, :passiverules_2, :passiverules_3,
					:anim_left, :anim_top, :anim_right, :anim_bottom, :sound)");
					
					if (isset($data['cardTypes'][$i]['passiveRules'][0]['displayName'])) {
						$pass0 = $data['cardTypes'][$i]['passiveRules'][0]['displayName'];
					} else {
						$pass0 = "";
					}
					if (isset($data['cardTypes'][$i]['passiveRules'][1]['displayName'])) {
						$pass1 = $data['cardTypes'][$i]['passiveRules'][1]['displayName'];
					} else {
						$pass1 = "";
					}
					if (isset($data['cardTypes'][$i]['passiveRules'][2]['displayName'])) {
						$pass2 = $data['cardTypes'][$i]['passiveRules'][2]['displayName'];
					} else {
						$pass2 = "";
					}
					
					if (isset($data['cardTypes'][$i]['anim']['left'])) {
						$anim0 = $data['cardTypes'][$i]['anim']['left'];
					} else {
						$anim0 = NULL;
					}
					if (isset($data['cardTypes'][$i]['anim']['right'])) {
						$anim2 = $data['cardTypes'][$i]['anim']['right'];
					} else {
						$anim2 = NULL;
					}
					if (isset($data['cardTypes'][$i]['anim']['top'])) {
						$anim1 = $data['cardTypes'][$i]['anim']['top'];
					} else {
						$anim1 = NULL;
					}
					if (isset($data['cardTypes'][$i]['anim']['bottom'])) {
						$anim3 = $data['cardTypes'][$i]['anim']['bottom'];
					} else {
						$anim3 = NULL;
					}
					
					
					
					if (isset($data['cardTypes'][$i]['targetArea'])) {
						$targetArea = $data['cardTypes'][$i]['targetArea'];
					} else {
						$targetArea = "";
					}
					
					if (isset($data['cardTypes'][$i]['tags']['sound_attack'])) {
						$sound_attack = $data['cardTypes'][$i]['tags']['sound_attack'];
					} else {
						$sound_attack = "";
					}
					
					if (isset($data['cardTypes'][$i]['animationPreviewImage'])) {
						$animationPreviewImage = $data['cardTypes'][$i]['animationPreviewImage'];
					} else {
						$animationBundle = "";
					}
					
					if (isset($data['cardTypes'][$i]['animationBundle'])) {
						$animationBundle = $data['cardTypes'][$i]['animationBundle'];
					} else {
						$animationBundle = "";
					}
					
					
					if (isset($data['cardTypes'][$i]['flavor'])) {
						$flavor = $data['cardTypes'][$i]['flavor'];
					} else {
						$flavor = "";
					}
					
					$arr = array(
							'id' => $data['cardTypes'][$i]['id'],
							'name' => $data['cardTypes'][$i]['name'],
							'description' => $data['cardTypes'][$i]['description'],
							'kind' => $data['cardTypes'][$i]['kind'],
							'types' => $data['cardTypes'][$i]['subTypesStr'],
							'costgrowth' => $data['cardTypes'][$i]['costGrowth'],
							'costorder' => $data['cardTypes'][$i]['costOrder'],
							'costenergy' => $data['cardTypes'][$i]['costEnergy'],
							'costdecay' => $data['cardTypes'][$i]['costDecay'],
							'ap' => $data['cardTypes'][$i]['ap'],
							'ac' => $data['cardTypes'][$i]['ac'],
							'hp' => $data['cardTypes'][$i]['hp'],
							'flavor' => $flavor,
							'rarity' => $data['cardTypes'][$i]['rarity'],
							'scrollsSet' => $data['cardTypes'][$i]['set'],
							'targetarea' => $targetArea,
							'image' => $data['cardTypes'][$i]['cardImage'],
							'bundle' => $animationBundle,
							'animationpreview' => $animationBundle,
							'version' => "",
							'introduced' => "",
							'passiverules_1' => $pass0,
							'passiverules_2' => $pass1,
							'passiverules_3' => $pass2,
							'anim_left' => $anim0,
							'anim_top' => $anim1,
							'anim_right' => $anim2,
							'anim_bottom' => $anim3,
							'sound' => $sound_attack
							
						);
					
					$x->arrayBinder($query, $arr);
					
					

						if ($query->execute()) {
							$success = true;
						} else {
							$success = false;
						}
	
				}
			}
			
			if ($success == true) {
				$success = "Total of ".count($data['cardTypes'])." was added";
			}
				
		
	}

}


// rename
if (isset($_POST['submitRename'])) {
	$directory = 'resources/cardImages/';
	if ($handle = opendir($directory)) { 
	    while (false !== ($fileName = readdir($handle))) {     
	        $newName = $fileName.".png";
	        rename($directory . $fileName, $directory . $newName);
	    }
	    closedir($handle);
	}
}

if (isset($_POST['submitAddBadge'])) {
	$badge->newBadge($_POST['ign'], $_POST['badge'], $_POST['text']);
}

if (isset($_POST['submitDeleteBadge'])) {
	$badge->deleteBadge($_POST['id']);
}
$query = $db->prepare("SELECT * FROM scrollsCard");	
$query->execute();
$total_scrolls = $query->fetch(PDO::FETCH_ASSOC);
$total_Scroll = $query->rowCount();




if (isset($_POST['submitGuildScore'])) {
	
	$data = array();
	$requests = 5;
	$playerPerRquest = 400;
	
	for ($i = 0; $i < $requests; $i++) {
		
		$url = "http://a.scrollsguide.com/ranking?fields=name,gold,rating,rank,badgerank&limit=".$playerPerRquest."&start=".$i*$playerPerRquest;
		
		$jsondata = file_get_contents($url);
		$pullRequest = json_decode($jsondata, TRUE);
		
		if ($pullRequest['msg'] == "success") {
			
			for ($j = 0; $j < count($pullRequest['data']); $j++) {
				
				$data[$pullRequest['data'][$j]['name']] = array(
					"rating" => $pullRequest['data'][$j]['rating'],
					"badgerank" => $pullRequest['data'][$j]['badgerank'],
					"gold" => $pullRequest['data'][$j]['gold'],
					"rank" => $pullRequest['data'][$j]['rank']
				);
				


			}
			
		}
		
		
	}
	
	$guild_query = $db->prepare("SELECT * FROM guild");	
	$guild_query->execute();
	$guildID = 0;
	
	while ($guild = $guild_query->fetch(PDO::FETCH_ASSOC)) {
		$guildID = $guild['id'];
		$guild_data = array(
			"guild_members" => 0,
			"guild_ligal_members" => 0,
			"guild_rating" => 0,
			"guild_gold" => 0,
			"guild_score" => 0
			
		);
		
		$member_query = $db->prepare("SELECT * FROM guildMembers WHERE guild_id=:gid");
		$arr = array(
				'gid' => $guildID,
			);
		
		$x->arrayBinder($member_query, $arr);
		$member_query->execute();
		
		while ($member = $member_query->fetch(PDO::FETCH_ASSOC)) {
			if (isset($data[$member['user_id']])) {
				$guild_data['guild_members']++;
				
				if ($data[$member['user_id']]['badgerank'] != -1) {
					$guild_data['guild_ligal_members']++;
					
					$guild_data['guild_rating'] += $data[$member['user_id']]['rating'];
				}
				
				$guild_data['guild_gold'] += $data[$member['user_id']]['gold'];
			}
			
			// end while member
		}
		
		if ($guild_data['guild_rating'] != 0 && $guild_data['guild_ligal_members'] > 4) {
			$guild_data['guild_score'] = $guild_data['guild_rating'] / $guild_data['guild_ligal_members'];
		}
		
		
		$update_query = $db->prepare("UPDATE guild set guild_score=:score WHERE id=:gid");
		$arr = array(
				'score' => $guild_data['guild_score']
			);
		$arrInt = array(
				'gid' => $guildID
			);
		
		$x->arrayBinder($update_query, $arr);
		$x->arrayBinderInt($update_query, $arrInt);
		

			if ($update_query->execute()) {
				echo("<pre>");
				print_r($guild_data);
				echo("</pre>");	
			}
			
		//end while guilde
	}	
 // end if
}


	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolls - Alternative Profile Page</title>
	<link rel="stylesheet" href="<?php echo($main) ?>css/style.css" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="icon" type="image/png" href="img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="../jquery.js"></script>	 
	<script src="../plugins/ckeditor/ckeditor.js"></script>	
		
</head>
<body>
	 <?php include('inc_/menu.php'); ?>
	 
	 <div class="indexbg fullScreen">
 <?php if (isset($_SESSION['username']) && ($_SESSION['rank'] <= 2)) { ?>
	 	<div class="container">
	 		<div class="div-4">
	 			<h3 class="modern">Total Accounts: <?php echo($x->totalAccounts()) ?>, Total Decks: <?php echo($x->totalDecks()) ?>, Total Fanart made:  <?php echo($x->totalFanart()) ?></h3>
	 			
	 			<div class="div-4">
	 					<div class="wall_big">
	 				    <form method="post" action="">
	 				    	<h2>Update Scroll Library: (currently <?php echo($total_Scroll) ?> scrolls)</h2><br />
							<?php if (isset($success) && $success != false) { ?>
								<p class="color-green">
									<?php echo($success) ?>
								</p>
							<?php } ?>
							
	 				    	
	 				    	<input type="checkbox" class="normal_checkbox" name="file" id="file" checked="" value="" />
	 				    	<label for="file" class="normal_checkbox"></label>
	 				    	<label for="file" class="hand">From File</label>
	 				    	
	 				    	
								<select name="vFile">
	 				    		<?php 
	 				    		
	 				    		$dir    = 'admin/versions/';
	 				    		$files = scandir($dir);

	 				    		for ($i = 0; $i < count($files); $i++) {
	 				    			if ($files[$i] == ".") continue;
	 				    			if ($files[$i] == "..") continue;
	 				    		
	 				    			echo("<option>".$files[$i]."</option>");
	 				    		}


	 				    		
	 				    		 ?>
								</select>
	 				    	<input name="submitScrolls" type="submit" class="btn-modern" value="Update">
	 				    </form>
	 				    <?php if ($_SESSION['rank'] == 1) { ?>
	 				    <form method="post" action="">
	 				    	<h2>Add .png extesion to image files</h2>
	 				    	<input name="submitRename" type="submit" class="btn-modern" value="Rename">
	 				    </form>
	 					<?php  } ?>
	 					
	 					<div class="div-4">
	 						<h2>Guilds</h2>
	 						<form method="post" action="">
	 							<input type="submit" name="submitGuildScore" value="Update Guild Score" class="btn-modern btn-no-margin"/>
	 						</form>
	 					
	 					</div>
	 			</div>
	 			<div class="wall_small">
	 			<div class="div-4">
	 					<h2>Hidden Spoiler Posts</h2>
	 					<?php $query = $db->prepare("SELECT * FROM scrolls WHERE isHidden=1 ORDER BY time DESC");	
	 					$query->execute();
	 					
	 					while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
	 					
						<p><a href="spoiler.php?s=<?php echo($row['id']) ?>"><?php echo($row['header']) ?></a></p>
	 					
	 					<?php } ?>
	 					
	 				</div>
	 			<div class="div-4">
	 				<h2>Password resets:</h2>
	 					<ul>
	 					<?php $query = $db->prepare("SELECT * FROM resets ORDER BY id DESC");	
	 					$query->execute();
	 					
	 					while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
	 					
	 						<li><?php echo($row['ign']) ?> @ <?php echo($row['ip']) ?></li>
	 					
	 					<?php } ?>
	 				</ul>
	 				
	 				</div>
	 			</div>
	 			</div>
	 		</div>
	 	
	 	<div class="div-4">
	 		<h3 class="modern">Badges</h3>
	 		<form method="post" action="">
				<div class="div-4">
					<div class="div-4">
						<ul class="badge-icon-admin left">
							<?php for ($i = 0; $i < $badge->getBadge(0, true); $i++) { ?>
							
								<?php if ($badge->getBadge($i) == "icon-br") { ?>
									<br /><br />
								<?php } else { ?>
								
								<li>
									<input type="radio" name="badge" id="badge-<?php echo($i) ?>" value="<?php echo($i) ?>" />
									<label for="badge-<?php echo($i) ?>" class="checkbox"><i class="<?php echo($badge->getBadge($i)) ?>"></i></label>
									<ul>
										<li class="modern"><?php echo($badge->getBadge($i)) ?></li>
									</ul>
								</li>
								
								<?php } ?>
							<?php } ?>
							
						</ul>
					</div>
					<div class="div-4">
						<input list="player" name="ign" class="textbox span-4" placeholder="Badge for ['ign']">
						<datalist id="player">
						<?php 
							$query = $db->prepare("SELECT ign FROM accounts WHERE guild = 0");
							$query->execute();
		
							while ($player = $query->fetch(PDO::FETCH_ASSOC)) {
							echo("<option value='".$player['ign']."'>");
								
							 } ?>
						</datalist>
					</div>
					<div class="div-4">
						<input type="text" class="textbox span-4" name="text" value="" placeholder="Badge Text" />
					</div>
				</div>
				<div class="div-4">
					<input type="submit" name="submitAddBadge" value="Add" class="btn-modern btn-no-margin" />
				</div>
			</form>
	 		
	 		
	 		<div class="div-4">
	 			<div class="decks">
	 			<table class="div-4 bg">
	 				<tr>
	 					<td>Badge</td>
	 					<td>User</td>
	 					<td>Text</td>
	 					<td></td>
	 				</tr>
	 				
	 				<?php $query = $db->prepare("SELECT * FROM badges ORDER BY id DESC");
	 				$query->execute();
	 				
	 				while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
	 					<tr>
	 						<td><i class='<?php echo($row['type']) ?>'></i></td>
	 						<td><?php echo($row['user']) ?></td>
	 						<td><?php echo($row['text']) ?></td>
	 						
	 						<td>
	 							<form method="post" action="">
	 								<input type="hidden" name="id" value="<?php echo($row['id']) ?>" />
	 								<input type="submit" name="submitDeleteBadge" value="Del" class="btn-modern btn-no-margin" />
	 							</form>
	 						</td>
	 						
	 					</tr>
	 				<?php } ?>
	 			</table>
	 		</div>
	 		</div>
	 		
	 	</div>
</div>
				
			
			

<?php } else { ?>
	<div class="scrollsHardBack">
		<p>No access!</p>
	</div>
<?php } ?>
	 	</div>
	 </div>

<?php include("inc_/footer.php"); ?>
</body>
</html