<?php 
	include('../admin/mysql/connect.php');
	include_once('../admin/mysql/function.php');
	$x = new xClass();
	
	
	session_start();
	if (isset($_GET['logout'])) {
		$x->logout();
	}
	if (!isset($_SESSION['username'])) {
		header("location: ../login.php");
	}

	if (!$x->hasGuild($_SESSION['username'])) {
		header("location: ../login.php");
	}
	
	if (isset($_POST['submit'])) {
		//post: name, short_name, rating, desc
		
		if (!empty($_POST['name'])) {
			
			if (!empty($_POST['short_name'])) {
				
				if (strlen($_POST['short_name']) <=3 && strlen($_POST['short_name']) >= 1) {
					
					if (!empty($_POST['desc'])) {
					
						if (empty($_POST['rating'])) {
							$rating = 0;
						} else {
							$rating = $_POST['rating'];
						}
							if ($x->guildExist($_POST['name'])) {
								
								if ($x->guildShortExist($_POST['name'])) {
							
								if ($x->aleardyOwnGuild($_SESSION['username'])) {
										if (isset($_POST['isHidden'])) {
											$hidden = 1;
										} else {
											$hidden = 0;
										}
										
										$query = $db->prepare("INSERT INTO guild (name, short_name, requerd_rating, desciption, guild_leader, isHidden) VALUES(:name, :sName, :rating, :description, :leader, :isHidden)");
										$arr = array(
												'name' => $_POST['name'],
												'sName' => $_POST['short_name'],
												'rating' => $rating,
												'description' => $_POST['desc'],
												'leader' => $_SESSION['username'],
												'isHidden' => $hidden
											);
										
										$x->arrayBinder($query, $arr);
										
										try {
											if ($query->execute()) {
												
												if ($x->addGuildMember($_SESSION['username'], $x->getGuildID($_SESSION['username']))) {
													header("location: ../");
												}
												
											}
									} catch (PDOException $e) {
										return($this->errorHandle($e));
									}
								
								} else {
									$_GET['info'] = "Short guild name already exist";
								}
								
							} else {
								$_GET['info'] = "Guild name already exist";
							}
						} else {
							$_GET['info'] = "You already own a guild, you can not own more then 1 guild";
						}
					} else {
						$_GET['info'] = "Enter a Description for your guild";
					}
					
				} else {
					$_GET['info'] = "Short guild name need to be 1, 2 or 3 characters long";
				}
				
			} else {
				$_GET['info'] = "Enter a guild name";
			}
			
		} else {
			$_GET['info'] = "Enter a guild name";
		}
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Scrolldier.com - Create a Guild</title>
	<link rel="icon" type="image/png" href="../img/bunny.png">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="../css/style.css" />
</head>
<body>
	<div class="container">
	<?php include('../inc_/menu.php') ?>
		<?php if (isset($_GET['info'])) { ?>
			<p class="color-red"><?php echo($_GET['info']) ?></p>
		<?php } ?>
		<?php if (isset($_GET['success'])) { ?>
			<p class="color-green"><?php echo($_GET['success']) ?></p>
		<?php } ?>
	
		<form method="post" action="">
			<div class="div-3">
				<label for="pw_old">Guild Name</label><br />
				<input type="text" class="textbox full div-1" id="pw_old" name="name" value="" placeholder="Name"/>
			</div>
			<div class="div-3">
				<input type="checkbox" name="isHidden" id="isHidden" value="" />
				<label for="isHidden">Make guild hidden from the guild list</label>
			</div>	
			<div class="div-3">
				<label for="pw_new">Short Guild name (3 Characthers)</label><br />
				<input type="text" class="textbox full div-1" max="3" id="pw_new" name="short_name" value="" placeholder="Short name"/><br />
			</div>
			<div class="div-3">
				<label for="pw_new2">Required rating to join</label><br />
				<input type="text" class="textbox full div-1" id="pw_new2" name="rating" value="" placeholder="Required Rating"/>
			</div>
			<div class="div-3">
				<label for="pw_new2">Description of the guild</label><br />
				<textarea class="textarea" name="desc"></textarea>
			</div>
			
			<div class="div-3">
				<input type="submit" class="btn" name="submit" value="Create Guild" />
			</div>
		</form>
	</div>
	<?php include("../inc_/footer.php"); ?>
</body>
</html>