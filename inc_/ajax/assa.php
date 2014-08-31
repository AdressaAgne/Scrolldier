<?php 
include('../../admin/mysql/connect.php');
include('../../admin/mysql/function.php');
include('../../admin/mysql/badges.php');
$x = new xClass();
$badge = new badges();

session_start();

$code = "Kardonia";

if (isset($_SESSION['username'])) {
	if ($_POST['code'] === $code) {
		echo("Access Granted\n");
		
		$query = $db->prepare("SELECT * FROM badges WHERE type = :badge AND user = :ign");
		$arr = array(
			'badge' => "icon-assa",
			'ign' => $_SESSION['username']
		);

		$x->arrayBinder($query, $arr);
	
		$query->execute();
		
		if ($query->rowCount() < 1) {
			echo("Welcome to the Assassins Caller Program\n");
			echo("Your Assassin badge is in your profile\n");
			$badge->newBadgeText($_SESSION['username'], "icon-assa", "Member of the Assassin's Caller Program");
		} else {
			echo("Your already in the program\n");
		}
		
		
	} else {
		if ($_POST['code'] == "assassin") {
			
			$thingy = rand(0,13);
			
			if ($thingy == 9) {
				echo("Below Nor Peaks\n");
				
			} elseif ($thingy == 13) {
			
				echo("Frost + not mustache\n");
				
			} else {
				echo("G****h Unit\n");
			}
		
		} elseif (strtolower($_POST['code']) == "khaile"){
			echo("The old name\n");
		}
		
		echo("Access Denied\n");
	}
	
	
	
}
