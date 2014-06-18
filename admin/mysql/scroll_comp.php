<?php

class scrollsCompetition {	
	function arrayBinder(&$pdo, &$array) {
		foreach ($array as $key => $value) {
			$pdo->bindValue(':'.$key,$value);
		}
	}
		
	function newCompetition($sO, $sG, $sE, $sD, $desc, $start, $end, $title, $price, $author, $hidden = 0) {
		include("connect.php");
		
		$compQuery = $db->prepare("INSERT INTO competition (scrolls_order, scrolls_growth, scrolls_energy, scrolls_decay, description, comp_start, comp_end, title, price_pool, scrolls_hide, author) VALUES(:sO, :sG, :sE, :sD, :desc, :comp_s, :comp_e, :title, :price, :hidden, :author)");
		
		$compArray = array(
				'sO' => $sO,
				'sG' => $sG,
				'sE' => $sE,
				'sD' => $sD,
				'desc' => $desc,
				'comp_s' => $start,
				'comp_e' => $end,
				'title' => $title,
				'price' => $price,
				'hidden' => $hidden,
				'author' => $author
			); 
		
		$this->arrayBinder($compQuery, $compArray);
		
		return $compQuery->execute() ? true : false;	
		
	}
	
	function editCompetition($sO, $sG, $sE, $sD, $desc, $start, $end, $title, $price, $author, $hidden = 0) {
			include("connect.php");
	
			$compQuery = $db->prepare("UPDATE competition SET scrolls_order=:sO, scrolls_growth=:sG scrolls_energy=:sE, scrolls_decay=:sD, description=:desc, comp_start=:comp_s, comp_end=:comp_e, title=:title, price_pool=:price, scrolls_hide=:hidden, author=:author");
			
			$compArray = array(
					'sO' => $sO,
					'sG' => $sG,
					'sE' => $sE,
					'sD' => $sD,
					'desc' => $desc,
					'comp_s' => $start,
					'comp_e' => $end,
					'title' => $title,
					'price' => $price,
					'hidden' => $hidden,
					'author' => $author
				); 
			
			$this->arrayBinder($compQuery, $compArray);
			
			return $compQuery->execute() ? true : false;	
			
		}
	
	
	function deleteCompetition($id) {
		include("connect.php");
		
		$compQuery = $db->prepare("DELETE FROM competition where id = :id");
		$compArray = array(
				'id' => $id
			); 
		
		$this->arrayBinder($compQuery, $compArray);
		
		return $compQuery->execute() ? true : false;	
	}
	
	
	function addSubmition($user, $scrollID) {
		include("connect.php");
		
		$compQuery = $db->prepare("INSERT INTO competition_submitions (fan_scroll, user) VALUES(:scroll, :user)");
		
		$compArray = array(
				'scroll' => $scrollID,
				'user' => $user
			); 
		
		$this->arrayBinder($compQuery, $compArray);
		
		return $compQuery->execute() ? true : false;
	}
	function deleteSubmition($id) {
		include("connect.php");
		
		$compQuery = $db->prepare("DELETE FROM competition_submitions WHERE id = :id");
		
		$compArray = array(
				'id' => $id
			); 
		
		$this->arrayBinder($compQuery, $compArray);
		
		return $compQuery->execute() ? true : false;
	}


}

