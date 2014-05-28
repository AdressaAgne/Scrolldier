<?php 
	include('../admin/mysql/connect.php');
	include_once('../admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}
	$isGuildLeader = $x->isGuildLeader($_SESSION['username']);
	if (!$x->canEditGuild2($_SESSION['username']) && $isGuildLeader == false) {
		header("location: ../guild.php");
	}
	
	$query = $db->prepare("SELECT * FROM guild WHERE id = :id");
		
	$arr = array(
			'id' => $x->getGuildID2($_SESSION['username'])
		);
	
	$x->arrayBinder($query, $arr);	
	$query->execute();
	$g = $query->fetch(PDO::FETCH_ASSOC);
		
	if (isset($_POST['submit']) && isset($g['id'])) {
		$query = $db->prepare("UPDATE guild SET desciption=:desciption, badge_url=:badge, requerd_rating=:rating, isHidden=:isHidden, guild_leader=:guildLeader WHERE id=:id");
		
		if (empty($_POST['badge_url'])) {
			$badgeEdit = $g['badge_url'];
		} else {
			$badgeEdit = $_POST['badge_url'];
		}
		
		if (empty($_POST['requerd_rating'])) {
			$ratingEdit = $g['requerd_rating'];
		} else {
			$ratingEdit = $_POST['requerd_rating'];
		}
		if ($isGuildLeader == true) {
			if (isset($_POST['isHidden'])) {
				$hidden = 1;
			} else {
				$hidden = 0;
			}
		} else {
			$hidden = $g['isHidden'];
		}
		if (isset($_POST['guildLeader'])) {
			$guildLeader = $_POST['guildLeader'];
		} else {
			$guildLeader = $g['guild_leader'];
		}
		
		if (isset($_POST['desciption'])) {
			$desciptionP = $_POST['desciption'];
		} else {
			$desciptionP = $g['desciption'];
		}
		
		$arr = array(
				'desciption' => $desciptionP,
				'badge' => $badgeEdit,
				'rating' => $ratingEdit,
				'id' => $g['id'],
				'isHidden' => $hidden,
				'guildLeader' => $guildLeader
			);
		
		$x->arrayBinder($query, $arr);	
		if ($query->execute()) {
			$_GET['success'] = "Guild Updated";
			header("location: g.php?g=".$g['id']);
		} else {
			$_GET['info'] = "Error, plz contact support @ <a href='mailto:support@scrolldier.com'>support@scrolldier.com</a>";
		}
	}
	
	
	if (isset($_POST['submit']) && isset($_POST['premi'])) {
		if (!empty($_POST['name'])) {
				//name, badge, desc, inv, flair, kick, score, rating, prem, leader
				if (isset($_POST['badge'])) {
					$badge = 1;
				} else {
					$badge = 0;
				}
				if (isset($_POST['inv'])) {
					$inv = 1;
				} else {
					$inv = 0;
				}
				if (isset($_POST['desc'])) {
					$desc = 1;
				} else {
					$desc = 0;
				}
				if (isset($_POST['flair'])) {
					$flair = 1;
				} else {
					$flair = 0;
				}
				if (isset($_POST['kick'])) {
					$kick = 1;
				} else {
					$kick = 0;
				}
				if (isset($_POST['score'])) {
					$score = 1;
				} else {
					$score = 0;
				}
				if (isset($_POST['rating'])) {
					$rating = 1;
				} else {
					$rating = 0;
				}
				if (isset($_POST['prem'])) {
					$prem = 1;
				} else {
					$prem = 0;
				}
				if (isset($_POST['leader'])) {
					$leader = 1;
				} else {
					$leader = 0;
				}
				if (isset($_POST['msg'])) {
					$premi = 1;
				} else {
					$premi = 0;
				}
				if (isset($_POST['recrut'])) {
					$recrut = 1;
				} else {
					$recrut = 0;
				}
				
				
				$query = $db->prepare("INSERT INTO premitions (rank_name, rank_for_guild, allow_edit_badge, allow_members_invite, allow_edit_desc, allow_edit_flair, allow_members_kick, allow_update_score, allow_edit_rating, allow_edit_premitions, allow_edit_leader, allow_recruit_form, allow_guildwide_message) VALUES (:name, :gid, :badge, :invite, :desc, :flair, :kick, :score, :rating, :premi, :leader, :recrut, :msg)");
					//name, badge, desc, inv, flair, kick, score, rating, prem, leader
				$arr = array(
						'name' => $_POST['name'],
						'gid' => $g['id'],
						'badge' => $badge,
						'invite' => $inv,
						'desc' => $desc,
						'flair' => $flair,
						'kick' => $kick,
						'score' => $score,
						'rating' => $rating,
						'premi' => $prem,
						'leader' => $leader,
						'recrut' => $recrut,
						'msg' => $premi
					);
				
				$x->arrayBinder($query, $arr);	
				if ($query->execute()) {
					$_GET['success'] = "Succesfull";
				} else {
					$_GET['info'] = "Error, plz contact support @ <a href='mailto:support@scrolldier.com'>support@scrolldier.com</a>";
				}
			
			
		} else {
			$_GET['info'] = "Your rank need a name";
		}
	}
	
	if (isset($_POST['delSubmit'])) {
		if ($_POST['d'] == $g['id']) {
			
			$query = $db->prepare("DELETE FROM premitions where id = :id");
			$arr = array(
					'id' => $_POST['i']
				);
			
			$x->arrayBinder($query, $arr);
			$query->execute();
			
		} else {
			$_GET['info'] == "This rank are not a rank for your guild";
		}
	}
	
	if (isset($_POST['setRankSubmit'])) {
	
			$query = $db->prepare("UPDATE guildMembers SET rankID=:rank WHERE user_id=:user");
			$arr = array(
					'rank' => $_POST[$_POST['u'].'_rank'],
					'user' => $_POST['u']
				);
			
			$x->arrayBinder($query, $arr);
			
			$query->execute();
	}
	
	
	$query = $db->prepare("
		SELECT * FROM premitions
		JOIN guildMembers
		ON guildMembers.rankID = premitions.id
		WHERE guildMembers.user_id = :name");
	$arr = array(
			'name' => $_SESSION['username']
		);
	$x->arrayBinder($query, $arr);
	$query->execute();
	
	$p = $query->fetch(PDO::FETCH_ASSOC);
	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolldier.com</title>
	<?php if (empty($g['badge_url'])) { ?>
		<link rel="icon" type="image/png" href="../img/bunny.png">
	<?php } else { ?>
		<link rel="icon" type="image/png" href="<?php echo($g['badge_url']) ?>">
	<?php } ?>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="../css/style.css" />
	
	<script src="../jquery.js"></script>	 
	<script src="../plugins/ckeditor/ckeditor.js"></script>	
</head>
<body>

	<?php include('../inc_/menu.php') ?>
		<div class="container">
			<h1>Manage <?php echo($g['name']) ?></h1>
				
			<div class="decks div-margin">
					<form method="post" action="" class="clearfix">
						<?php if ($isGuildLeader == true) { ?>
						
						<?php if ($g['isHidden'] == 1) {
							$isHidden = "checked";
						} else {
							$isHidden = "";
						}?>
						
						<div class="div-3">
							<input <?php echo($isHidden) ?> type="checkbox" name="isHidden" id="isHidden" value="" />
							<label for="isHidden">Make guild hidden from the guild list</label>
						</div>
						<?php } ?>
						
						<?php if ($p['allow_edit_leader'] == 1 || $isGuildLeader == true) { ?>
						<div class="div-4">
							<div class="div-3 div-margin">
								<label for="gd">Change Guild Leader</label>
							</div>
							<div class="div-4">
							<?php 
							
							$query = $db->prepare("
								SELECT * FROM guild
								LEFT JOIN guildMembers
								ON  guild.id = guildMembers.guild_id WHERE guildMembers.guild_id = :id");
							
							$arr = array(
							'id' => $g['id']
							);
							
							$x->arrayBinder($query, $arr);	
							$query->execute();
							
							 ?>
								<select name="guildLeader">
									<?php while ($leader = $query->fetch(PDO::FETCH_ASSOC)) {
										
										if ($x->isGuildLeader($leader['user_id'])) {
											echo("<option selected value='".$leader['user_id']."'>".$leader['user_id']."</option>");
										} else {
											echo("<option value='".$leader['user_id']."'>".$leader['user_id']."</option>");
										}
										
									} ?>
								</select>
							</div>
						</div>
						<?php } ?>
						
						<?php if ($p['allow_edit_flair'] == 1 || $isGuildLeader == true) { ?>
						<div class="div-3 clearfix">
							<div class="div-3 clearfix">
								<div class="div-3 div-margin">
									<label for="badge_url">Guild Flair (16x16)<span class="badge"><img src="<?php echo($g['badge_url']) ?>" alt="" /></span></label>
								</div>
								<input type="text" id="badge_url" class="textbox full" placeholder="Image Url" name="badge_url" value="<?php echo($g['badge_url']) ?>" />
							</div>
						</div>
						<?php } ?>
						
						<?php if ($p['allow_edit_rating'] == 1 || $isGuildLeader == true) { ?>
						<div class="div-3 clearfix">
							<div class="div-3 clearfix">
								<div class="div-3 div-margin">
									<label for="badge_url">Required Rating to Join</label>
								</div>
								<input type="text" id="badge_url" class="textbox full" name="requerd_rating" value="<?php echo($g['requerd_rating']) ?>" />
							</div>
						</div>
						<?php } ?>
						
						<?php if ($p['allow_edit_desc'] == 1 || $isGuildLeader == true) { ?>
						<div class="div-4">
							<div class="div-3 div-margin">
								<label for="editor">Guild Description</label>
							</div>
							<div class="div-4">
								<textarea class="ckeditor" id="editor" name="desciption"><?php echo($g['desciption']) ?></textarea>
							</div>
						</div>
						<?php } ?>
						
						<?php if ($p['allow_edit_desc'] == 1 ||
								  $p['allow_edit_rating'] == 1 ||
								  $p['allow_edit_flair'] == 1 ||
								  $isGuildLeader == true ) { ?>
						<div class="div-3">
							<div class="div-3">
								<input type="submit" class="btn" name="submit" value="Update Guild" />
							</div>
						</div>
						<?php } ?>
					</form>
			
			</div>
			
			
			<?php if ($p['allow_edit_premitions'] == 1 || $isGuildLeader == true) { ?>
			<br /><br /><br />
			<h1 style="margin-top: 20px;">Ranks & Permissions</h1>
			<div class="clearfix">
				<div class="settings-element left" style="width: 550px;">
				<p>Add a new Rank for your guild</p>
				<form method="post" class="form" action="" class="settings-element">
				
					<div class="div-3 div-margin">
						<p>Choose a name for your rank</p>
						<span><input type="text" class="textbox full" style="" name="name" value="" placeholder="Rank name" /></span>
					</div>
					
					<div class="div-3 div-bottom">
						<span class="chooseBoxPremi">
							<input type="checkbox" name="badge" id="badge" value="" />
							<label class="checkbox" for="badge"><i class="icon-"></i></label> 
						</span>
						<label for="badge">Allow user to change the Badge "<?php echo($g['short_name']) ?>"</label>
					</div>
					<div class="div-3 div-bottom">
						<span class="chooseBoxPremi">
							<input type="checkbox" name="desc" id="desc" value="" />
							<label class="checkbox" for="desc"><i class="icon-"></i></label> 
						</span>
						<label for="desc">Allow user to change <b>the description</b> of the <?php echo($g['name']) ?> guild</label>
					</div>
					
					<div class="div-3 div-bottom">
						<span class="chooseBoxPremi">
							<input type="checkbox" name="inv" id="inv" value="" />
							<label class="checkbox" for="inv"><i class="icon-"></i></label> 
						</span>
						<label for="inv">Allow user to <b>invite</b> others to <?php echo($g['name']) ?></label>
					</div>
					<div class="div-3 div-bottom">
						<span class="chooseBoxPremi">
							<input type="checkbox" name="flair" id="flair" value="" />
							<label class="checkbox" for="flair"><i class="icon-"></i></label> 
						</span>
						<label for="flair">Allow user to change the Guild Flair <span class="badge"><img src="<?php echo($g['badge_url']) ?>" alt="" /></span></label>
					</div>
					<div class="div-3 div-bottom">
						<span class="chooseBoxPremi">
							<input type="checkbox" name="kick" id="kick" value="" />
							<label class="checkbox" for="kick"><i class="icon-"></i></label> 
						</span>
						<label for="kick">Allow user to kick players from <?php echo($g['name']) ?></label>
					</div>	
					<div class="div-3 div-bottom">
						<span class="chooseBoxPremi">
							<input type="checkbox" name="score" id="score" value="" />
							<label class="checkbox" for="score"><i class="icon-"></i></label> 
						</span>
						<label for="score">Allow user to update the guild score (<?php echo($g['guild_score']) ?>)</label>
					</div>	
					<div class="div-3 div-bottom">
						<span class="chooseBoxPremi">
							<input type="checkbox" name="rating" id="rating" value="" />
							<label class="checkbox" for="rating"><i class="icon-"></i></label> 
						</span>
						<label for="rating">Allow user to change the Required Rating to join <?php echo($g['name']) ?></label>
					</div>	
					<div class="div-3 div-bottom">
						<span class="chooseBoxPremi">
							<input type="checkbox" name="prem" id="prem" value="" />
							<label class="checkbox" for="prem"><i class="icon-"></i></label> 	
						</span>
						<label for="prem">Allow user to add, remove or assign ranks to members</label>
					</div>	
					<div class="div-3 div-bottom">
						<span class="chooseBoxPremi">
							<input type="checkbox" name="leader" id="leader" value="" />
							<label class="checkbox" for="leader"><i class="icon-"></i></label> 	
						</span>
						<label for="leader">Allow user to change the guild Leader (<?php echo($g['guild_leader']) ?>)</label>
					</div>	
					<div class="div-3 div-bottom">
						<span class="chooseBoxPremi">
							<input type="checkbox" name="msg" id="msg" value="" />
							<label class="checkbox" for="msg"><i class="icon-"></i></label> 	
						</span>
						<label for="msg">Allow user to send out a message to everyone in the guild</label>
					</div>	
					<div class="div-3 div-bottom">
						<span class="chooseBoxPremi">
							<input type="checkbox" name="recrut" id="recrut" value="" />
							<label class="checkbox" for="recrut"><i class="icon-"></i></label> 	
						</span>
						<label for="recrut">Allow user to toggle the guild recruitment form on and off</label>
					</div>
					<div class="div-3">
						<input type="hidden" name="premi" value="premi" />
						<label><input type="submit" name="submit" class="btn-modern" value="Add" /></label>
					</div>
				</form>
			</div>
				
				<?php 
				
					$optionList = "";
					$query = $db->prepare("SELECT * FROM premitions WHERE rank_for_guild = :id ORDER BY id DESC");
					
					$arr = array(
					'id' => $g['id']
					);
					
					$x->arrayBinder($query, $arr);	
					$query->execute();
					
					while ($rank = $query->fetch(PDO::FETCH_ASSOC)) {
						$optionList .= "<option value='".$rank['id']."'>".$rank['rank_name']."</option>";
					}
					
					$query = $db->prepare("
						SELECT * FROM guild
						LEFT JOIN guildMembers
						ON  guild.id = guildMembers.guild_id WHERE guildMembers.guild_id = :id");
					
					$arr = array(
					'id' => $g['id']
					);
					
					$x->arrayBinder($query, $arr);	
					$query->execute();
					
				 ?>
				
				<div class="settings-element right" style="width: 400px;">
					<div class="decks">
						<p>Assign ranks</p>
						<table class="left" style="width: 400px !important;">
							<tr class="modern">
								<td>Rank</td>
								<td>Member</td>
								<td></td>
							</tr>
							<?php while ($gM = $query->fetch(PDO::FETCH_ASSOC)) { ?>
							<tr>
								<form method="post" action="">
								<td>
									<?php 
										if (!empty($optionList)) {
											echo('<select name="'.$gM['user_id'].'_rank">');
											echo("<option selected value='".$gM['rankID']."'>".$x->getRankName($gM['rankID'])."</option>");
											
											echo($optionList);
											echo("<option value='0'>None</option>");
											echo('</select>');
										} else {
											echo('No ranks');
										}
										
									
									 ?>
							
								</td>
								<td><?php echo($gM['user_id']) ?></td>
								<td>
									<input type="hidden" name="u" value="<?php echo($gM['user_id']) ?>" />
									<input type="submit" class="btn-modern" name="setRankSubmit" value="Set Rank" />
								</td>
								</form>
							</tr>
							<?php 	} ?>
						</table>
					</div>
				
				</div>
			</div>
			<div class="div-margin div-4 settings-element" style="margin-bottom: 50px;">
				<div class="decks">
				<p class="color-red">Red header means that its not implemented yet</p>
					<table>
						<tr class="modern">
							<td>Rank</td>
							<td>Badge</td>
							<td>Description</td>
							<td>Invite</td>
							<td>Flair</td>
							<td class="color-red">Kick</td>
							<td class="color-red">Score</td>
							<td>Rating</td>
							<td>Permissions</td>
							<td>Leader</td>
							<td class="color-red">Messages</td>
							<td class="color-red">Recruit</td>
							<td></td>
						</tr>
						
						<?php 
						$query = $db->prepare("SELECT * FROM premitions WHERE rank_for_guild = :id ORDER BY id DESC");
						
						$arr = array(
						'id' => $g['id']
						);
						
						$x->arrayBinder($query, $arr);	
						$query->execute();
						while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
						<tr>
							<td><?php echo($row['rank_name']) ?></td>
							<td>
								<?php if ($row['allow_edit_badge'] == 1) {
									echo('<i class="icon-yes"></i>');
								} else {
									echo('<i class="icon-no"></i>');
								} ?>
							</td>
							<td>
								<?php if ($row['allow_edit_desc'] == 1) {
									echo('<i class="icon-yes"></i>');
								} else {
									echo('<i class="icon-no"></i>');
								} ?>
							</td>
							<td>
								<?php if ($row['allow_members_invite'] == 1) {
									echo('<i class="icon-yes"></i>');
								} else {
									echo('<i class="icon-no"></i>');
								} ?>
							</td>
							<td>
								<?php if ($row['allow_edit_flair'] == 1) {
									echo('<i class="icon-yes"></i>');
								} else {
									echo('<i class="icon-no"></i>');
								} ?>
							</td>
							<td>
								<?php if ($row['allow_members_kick'] == 1) {
									echo('<i class="icon-yes"></i>');
								} else {
									echo('<i class="icon-no"></i>');
								} ?>
							</td>
							<td>
								<?php if ($row['allow_update_score'] == 1) {
									echo('<i class="icon-yes"></i>');
								} else {
									echo('<i class="icon-no"></i>');
								} ?>
							</td>
							<td>
								<?php if ($row['allow_edit_rating'] == 1) {
									echo('<i class="icon-yes"></i>');
								} else {
									echo('<i class="icon-no"></i>');
								} ?>
							</td>
							<td>
								<?php if ($row['allow_edit_premitions'] == 1) {
									echo('<i class="icon-yes"></i>');
								} else {
									echo('<i class="icon-no"></i>');
								} ?>
							</td>
							<td>
								<?php if ($row['allow_edit_leader'] == 1) {
									echo('<i class="icon-yes"></i>');
								} else {
									echo('<i class="icon-no"></i>');
								} ?>
							</td>
							<td>
								<?php if ($row['allow_guildwide_message'] == 1) {
									echo('<i class="icon-yes"></i>');
								} else {
									echo('<i class="icon-no"></i>');
								} ?>
							</td>
							<td>
								<?php if ($row['allow_recruit_form'] == 1) {
									echo('<i class="icon-yes"></i>');
								} else {
									echo('<i class="icon-no"></i>');
								} ?>
							</td>
							<td>
								<form method="post" action="">
									<input type="hidden" name="i" value="<?php echo($row['id']) ?>" />
									<input type="hidden" name="d" value="<?php echo($row['rank_for_guild']) ?>" />
									<input type="submit" class="btn-modern" name="delSubmit" value="Delete" />
								</form>
							</td>				
						</tr>
						<?php } ?>

					</table>
				</div>
			</div>
			<?php } ?>
		</div>
	<?php include("../inc_/footer.php"); ?>
</body>
</html>