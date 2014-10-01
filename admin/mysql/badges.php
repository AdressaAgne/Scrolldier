<?php

class badges {	
	public $connect = "../connect.php";
	
	function arrayBinder(&$pdo, &$array) {
		foreach ($array as $key => $value) {
			$pdo->bindValue(':'.$key,$value);
		}
	}
		
	function getBadge($i, $count = false) {
		$badgeIcons = array(
			"win-most",
			"win-1st",
			"win-2nd",
			"win-3rd",
			"1st",
			"2nd",
			"3rd",
			"ig-mod",
			"guild",
			"sgAdmin",
			"beetle",
			"dota",
			"crad",
			"icecream",
			"nr-200",
			"topDonor",
			"gold_bunny",
			"silver_bunny",
			"bronze_bunny",
			"br",
			"carrot",
			"shard-pile",
			"curse",
			"frame",
			"br",
			"order-glow",
			"decay-glow",
			"energy-glow",
			"growth-glow",
			"wild-glow",
			"br",
			"Adventurer",
			"Adept",
			"Trickster",
			"Sorcerer",
			"Apprentice-Caller",
			"Caller",
			"Accomplished-Caller",
			"Master-Caller",
			"Exalted-Caller",
			"Grand-Master",
			"Aspect-Commander",
			"Ascendant",
			"br",
			"mnd-master-winner",
			"mnd-winner"
		);
		if ($count == false) {
			return "icon-".$badgeIcons[$i];
		} else {
			return count($badgeIcons);
		}
		
	}
	
	
	
	function newBadge($ign, $badge, $text) {
		include("connect.php");
		//Table: badges: id, type, text, user, time
		
		$badgeQuery = $db->prepare("INSERT INTO badges (type, text, user) VALUES(:type, :text, :ign)");
		
		$badgeArray = array(
				'type' => $this->getBadge($badge),
				'ign' => strtolower($ign),
				'text' => $text
			); 
		
		$this->arrayBinder($badgeQuery, $badgeArray);
		
		return $badgeQuery->execute() ? true : false;	
	}
	
	function newBadgeText($ign, $badge, $text) {
		include("connect.php");
		//Table: badges: id, type, text, user, time
		
		$badgeQuery = $db->prepare("INSERT INTO badges (type, text, user) VALUES(:type, :text, :ign)");
		
		$badgeArray = array(
				'type' => $badge,
				'ign' => strtolower($ign),
				'text' => $text
			); 
		
		$this->arrayBinder($badgeQuery, $badgeArray);
		
		return $badgeQuery->execute() ? true : false;	
	}
	
	function deleteBadge($id) {
		include("connect.php");
		
		$badgeQuery = $db->prepare("DELETE FROM badges where id = :id");
		$badgeArray = array(
				'id' => $id
			); 
		
		$this->arrayBinder($badgeQuery, $badgeArray);
		
		return $badgeQuery->execute() ? true : false;	
	}


}

