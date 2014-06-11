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

	$url = "http://a.scrollsguide.com/scrolls";
	$json = file_get_contents($url);
	$data = json_decode($json, TRUE);
	if ($data['msg'] == "success") { 
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
	 		<div class="wall_small">
	 			<h3 class="modern">Total Accounts: <?php echo($x->totalAccounts()) ?></h3>
	 			<div class="div-4">
	 					
	 				    <form method="post" action="">
	 				    	<label>Update Scroll Library:</label>
	 				    	<input name="submitScrolls" type="submit" class="btn-modern" value="Update">
	 				    </form>
	 				   
	 				    <?php if ($_SESSION['rank'] == 1) { ?>
	 				    <form method="post" action="">
	 				    	<label>Rename files to add .png</label>
	 				    	<input name="submitRename" type="submit" class="btn-modern" value="Rename">
	 				    </form>
	 					<?php  } ?>
	 			
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
	 	
	 	<div class="wall_big">
	 		<h3 class="modern">Badges</h3>
	 		<form method="post" action="">
				<div class="div-4">
					<div class="div-4">
						<ul class="badge-icon-admin left">
							<?php for ($i = 0; $i < $badge->getBadge(0, true); $i++) { ?>
								<li>
									<input type="radio" name="badge" id="badge-<?php echo($i) ?>" value="<?php echo($i) ?>" />
									<label for="badge-<?php echo($i) ?>" class="checkbox"><i class="<?php echo($badge->getBadge($i)) ?>"></i></label>
								</li>
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