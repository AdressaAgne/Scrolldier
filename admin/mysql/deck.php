<?php

class deck {	
	
	function arrayBinder(&$pdo, &$array) {
		foreach ($array as $key => $value) {
			$pdo->bindValue(':'.$key,$value);
		}
	}
	
	function arrayBinderInt(&$pdo, &$array) {
		foreach ($array as $key => $value) {
			$pdo->bindValue(':'.$key, (int) $value, PDO::PARAM_INT);
		}
	}
	
	
	function getLatestMainServerVersion() {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM scrolldier_settings WHERE type=1 AND value_int=1 ORDER BY id DESC LIMIT 1");

		if ($query->execute()) {
			$deck = $query->fetch(PDO::FETCH_ASSOC);
			
			return $deck['value_var'];
		}
	}
	function getLatestTestServerVersion() {
		include('connect.php');
			$query = $db->prepare("SELECT * FROM scrolldier_settings WHERE type=1 AND value_int=0 ORDER BY id DESC LIMIT 1");
	
			if ($query->execute()) {
				$deck = $query->fetch(PDO::FETCH_ASSOC);
				
				return $deck['value_var'];
			}
		}
	
	function addServerVersion($version, $test) {
		include('connect.php');
		$query = $db->prepare("INSERT INTO scrolldier_settings (name, value_int, value_var, type) VALUES (:name, :int, :var, :type)");
		
		if ($test === false) {
			$test = 0;
		} else {
			$test = 1;
		}

		
		$arr = array(
				'name' => "scrolls library",
				'var' => $version
			);
		$this->arrayBinder($query, $arr);
		
		//type = scrolls server versions
		$arr = array(
				'int' => $test,
				'type' => 1
			);
		$this->arrayBinderInt($query, $arr);
		

		return $query->execute();

	}
	function removeVerson($id) {
		include('connect.php');
		
		
		$query = $db->prepare("DELETE FROM scrolldier_settings WHERE id = :id");

		$arr = array(
				'id' => $id
			);
		$this->arrayBinderInt($query, $arr);
		

		return $query->execute();
	}
	function addFavoriteDeck($name, $deck) {
		include('connect.php');
		
		$query = $db->prepare("INSERT INTO favDeck (user, deck_id) VALUES(:user, :deck)");
		$arr = array(
				'user' => $name,
				'deck' => $deck
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			return $query->execute();
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	
	function removeFavoriteDeck($name, $deck) {
		include('connect.php');
		
		$query = $db->prepare("DELETE FROM favDeck WHERE deck_id = :id AND user = :name");
		$arr = array(
				'id' => $deck,
				'name' => $name
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			return $query->execute();
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function getDeckDetails($id, $gold = false) {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM decks WHERE id=:id");
		$arr = array(
				'id' => $id
			);
		$this->arrayBinder($query, $arr);
		
		if ($query->execute()) {
			$deck = $query->fetch(PDO::FETCH_ASSOC);
			$result = array(
				"CREATURE" => 0,
				"STRUCTURE" => 0,
				"SPELL" => 0,
				"ENCHANTMENT" => 0,
				"faction" => "",
				"gold_buy" => 0,
				"gold_sell" => 0,
				"gold_average" => 0,
				"gold_string" => ""
				
			);
			
			$factionsCost = array(
				"growth" => 0,
				"order" => 0,
				"energy" => 0,
				"decay" => 0
			);
			
			$scrollID = array();
			
			$getString = "";
			$json = $deck['JSON'];
			$data = json_decode($json, TRUE);
			if ($data['msg'] == "success") { 
			
				for ($i = 0; $i < count($data['data']['scrolls']); $i++) {
					$query = $db->prepare("SELECT * FROM scrollsCard WHERE id=:id");
					$arr = array(
							'id' => $data['data']['scrolls'][$i]['id']
						);
					
					$this->arrayBinderInt($query, $arr);
					$query->execute();		
					$scroll = $query->fetch(PDO::FETCH_ASSOC);
					
					$result[$scroll['kind']] += $data['data']['scrolls'][$i]['c'];
					
					if (!empty($scroll['costgrowth'])) {
						$factionsCost["growth"] += $data['data']['scrolls'][$i]['c'];
					}
					if (!empty($scroll['costorder'])) {
						$factionsCost["order"] += $data['data']['scrolls'][$i]['c'];
					}
					if (!empty($scroll['costenergy'])) {
						$factionsCost["energy"]+= $data['data']['scrolls'][$i]['c'];
					}
					if (!empty($scroll['costdecay'])) {
						$factionsCost["decay"]+= $data['data']['scrolls'][$i]['c'];
					}
					if ($gold) {
						$getString .= $scroll['id'].",";
					}
					
					array_push($scrollID, array(
						"id" => $data['data']['scrolls'][$i]['id'],
						"c" => $data['data']['scrolls'][$i]['c']
					));
					
				}
			
				if ($gold) {
					$getString = rtrim($getString, ",");
					//http://a.scrollsguide.com/prices?id=212,178
					
					$json = "http://a.scrollsguide.com/prices?id=".$getString;
					$json = file_get_contents($json);
					$data = json_decode($json, TRUE);
					
					if ($data['msg'] == "success") { 
						$result['gold_string'] = $data['data'];
					
					
					$gold = array();
					
					for ($i = 0; $i < count($data['data']); $i++) {
						$gold[$data['data'][$i]['id']]['buy'] = $data['data'][$i]['buy'];
						$gold[$data['data'][$i]['id']]['sell'] = $data['data'][$i]['sell'];
					}
					
					for ($i = 0; $i < count($scrollID); $i++) {
						$result['gold_buy'] += $gold[$scrollID[$i]['id']]['buy'] * $scrollID[$i]['c'];
						$result['gold_sell'] += $gold[$scrollID[$i]['id']]['sell'] * $scrollID[$i]['c'];
					}
					
					$result['gold_average'] = ($result['gold_buy'] + $result['gold_sell']) / 2;
					
					} else {
						$result['gold_string'] = $data['msg'];
					}
				}
				
				$result['faction'] = array_keys($factionsCost, max($factionsCost));
				array_push($result, $factionsCost);
				return $result;
			
			}
		}
	}
	
	function getDeckFaction($json) {
		include('connect.php');
			$factionsCost = array(
				"growth" => 0,
				"order" => 0,
				"energy" => 0,
				"decay" => 0
			);
			
			
			$getString = "";
			$json = $json;
			$data = json_decode($json, TRUE);
			if ($data['msg'] == "success") { 
			
				for ($i = 0; $i < count($data['data']['scrolls']); $i++) {
					$query = $db->prepare("SELECT * FROM scrollsCard WHERE id=:id");
					$arr = array(
							'id' => $data['data']['scrolls'][$i]['id']
						);
					
					$this->arrayBinderInt($query, $arr);
					$query->execute();		
					$scroll = $query->fetch(PDO::FETCH_ASSOC);
					
					
					if (!empty($scroll['costgrowth'])) {
						$factionsCost["growth"] += $data['data']['scrolls'][$i]['c'];
					}
					if (!empty($scroll['costorder'])) {
						$factionsCost["order"] += $data['data']['scrolls'][$i]['c'];
					}
					if (!empty($scroll['costenergy'])) {
						$factionsCost["energy"]+= $data['data']['scrolls'][$i]['c'];
					}
					if (!empty($scroll['costdecay'])) {
						$factionsCost["decay"]+= $data['data']['scrolls'][$i]['c'];}
					
				}
			
				return $factionsCost;
			
			}
		
	}
}