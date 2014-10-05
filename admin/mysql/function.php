<?php
class xClass {	
	function errorHandle(PDOException $e) {	
		return "Error code: ".$e->getCode();
	}
	
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
	
	function getSession($id) {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM accounts WHERE id=:id");
		$arr = array(
				'id' => $id
			);
		
		$this->arrayBinder($query, $arr);
		
		
		try {
			$query->execute();
			
			return $query->fetch(PDO::FETCH_ASSOC);
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	
	function warnUser($user) {
		include('connect.php');
		$query = $db->prepare("UPDATE accounts SET Warning=Warning+1 WHERE ign=:ign");
		$arr = array(
				'ign' => $user
			); 
		
		$this->arrayBinder($query, $arr);
		
		
		try {
			if ($query->execute()) {
				return true;
			}
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function warnPost($id) {
		include('connect.php');
		$query = $db->prepare("UPDATE comment SET Warning=Warning+1 WHERE id=:id");
		$arr = array(
				'id' => $id
			); 
		
		$this->arrayBinder($query, $arr);
		
		
		try {
			if ($query->execute()) {
				return true;
			}
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function isFavDeck($user, $id) {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM favDeck WHERE deck_id=:id AND user=:ign");
		$arr = array(
				'id' => $id,
				'ign' => $user
			);
		
		$this->arrayBinder($query, $arr);
		
		
		try {
			$query->execute();
			
			if ($query->rowCount() == 1) {
				return false;
			} else {
				return true;
			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function hasVoted($user, $id) {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM votes WHERE id_post=:id AND id_user=:ign");
		$arr = array(
				'id' => $id,
				'ign' => $user
			);
		
		$this->arrayBinder($query, $arr);
		
		
		try {
			$query->execute();
			
			if ($query->rowCount() == 1) {
				return false;
			} else {
				return true;
			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	
function deckVote($id, $value=true, $user) {
		include('connect.php');
	if ($this->hasVoted($user, $id)) {
		if ($value == false) {
			$query = $db->prepare("UPDATE decks SET Vote=Vote-1 WHERE id=:id");
		} else {
			$query = $db->prepare("UPDATE decks SET Vote=Vote+1 WHERE id=:id");
		}
		
		$arr = array(
				'id' => $id
			); 
		
		$this->arrayBinder($query, $arr);
		
		
		try {
			if ($query->execute()) {	
						
				$vote = $db->prepare("INSERT INTO votes (id_post, id_user, state) VALUES(:post, :user, :state)");
				
				if ($value == false) {
					$state = 0;
				} else {
					$state = 1;
				}
				
				$votearr = array(
						'post' => $id,
						'user' => $user,
						'state' => $state
					); 
				
				$this->arrayBinder($vote, $votearr);
				
					if ($vote->execute()) {
						return true;
					} else {
						return false;
					}
			} else {
				return false;
			}
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
}
	
	function playerExist($ign) {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM accounts WHERE ign=:ign");
		$arr = array(
				'ign' => $ign
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			$query->execute();
			if ($query->rowCount() === 1) {
				return false;
			} else {
				return true;
			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function getGuild($name) {
		include('connect.php');
		$query = $db->prepare("
			SELECT * FROM guild
			INNER JOIN guildMembers
			ON guild.id = guildMembers.guild_id WHERE guildMembers.user_id = :name");
		$arr = array(
				'name' => $name
			);
		
		$this->arrayBinder($query, $arr);
		
		$query->execute();
		$row = $query->fetch(PDO::FETCH_ASSOC);
		
		return $row;	
	}
	
	
	
	function guildExist($name) {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM guild WHERE name=:name");
		$arr = array(
				'name' => $name
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			$query->execute();
			if ($query->rowCount() === 1) {
				return false;
			} else {
				return true;
			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function hasGuild($name) {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM guildMembers WHERE user_id=:name");
		$arr = array(
				'name' => $name
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			$query->execute();
			
			if ($query->rowCount() === 1) {
				return false;
			} else {
				return true;
			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function guildShortExist($name) {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM guild WHERE short_name=:name");
		$arr = array(
				'name' => $name
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			$query->execute();
			if ($query->rowCount() === 1) {
				return false;
			} else {
				return true;
			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function aleardyOwnGuild($name) {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM guild WHERE guild_leader=:name");
		$arr = array(
				'name' => $name
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			$query->execute();
			if ($query->rowCount() === 1) {
				return false;
			} else {
				return true;
			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function totalUserComments($name) {
		include('connect.php');
		$query = $db->prepare("SELECT byUser FROM comment WHERE byUser=:name");
		$arr = array(
				'name' => $name
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			
			if ($query->execute()) {
				$count = $query->rowCount();
				return $count;
			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	
	function totalDeckVote($name) {
		include('connect.php');
		$query = $db->prepare("SELECT id_user FROM votes WHERE id_user=:name");
		$arr = array(
				'name' => $name
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			
			if ($query->execute()) {
				$count = $query->rowCount();
				return $count;
			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function isGuildLeader($gl) {
			include('connect.php');
			
			$query = $db->prepare("SELECT * FROM guild WHERE guild_leader=:name");
			$arr = array(
					'name' => $gl
				);
			
			$this->arrayBinder($query, $arr);
			
			try {
				
				if ($query->execute()) {
					if ($query->rowCount() >= 1) {
						return true;
					} else {
						return false;
					}
				}
				
			} catch (PDOException $e) {
				return($this->errorHandle($e));
			}
		
	}
	function getGuildID($gleader) {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM guild WHERE guild_leader=:name");
		$arr = array(
				'name' => $gleader
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			
			if ($query->execute()) {
				$row = $query->fetch(PDO::FETCH_ASSOC);
				return $row['id'];
			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function getUserRank($ign) {
		include('connect.php');
		$query = $db->prepare("SELECT rank FROM accounts WHERE ign=:ign");
		$arr = array(
				'ign' => $ign
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			
			if ($query->execute()) {
				$row = $query->fetch(PDO::FETCH_ASSOC);
				return $row['rank'];
			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function isAlphaUser($ign) {
		include('connect.php');
		$query = $db->prepare("SELECT id FROM accounts WHERE ign=:ign");
		$arr = array(
				'ign' => $ign
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			
			if ($query->execute()) {
				$row = $query->fetch(PDO::FETCH_ASSOC);
				

					return $row['id'];

			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function getGuildID2($name) {
		include('connect.php');
		$query = $db->prepare("
			SELECT * FROM guildMembers
			JOIN guild
			ON  guild.id = guildMembers.guild_id WHERE guildMembers.user_id = :name ");
		$arr = array(
				'name' => $name
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			
			if ($query->execute()) {
				$row = $query->fetch(PDO::FETCH_ASSOC);
				return $row['id'];
			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	
	function addGuildMember($name, $guild, $lead=true) {
		include('connect.php');
		
		$query = $db->prepare("INSERT INTO guildMembers (guild_id, user_id) VALUES(:guild, :name)");
		$arr = array(
				'guild' => $guild,
				'name' => $name
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			if ($query->execute()) {
				return true;
			} else {
				return false;
			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	
	
	
	function insertNewUser($username, $password, $name, $rank) {
		include('connect.php');
		$query = $db->prepare("INSERT INTO accounts (nick, password, rank) VALUES(:username, :password, :rank)");
		$arr = array(
				'username' => $username,
				'password' => sha1($password),
				'name' => $name,
				'rank' => $rank
			);
		
		$this->arrayBinder($query, $arr);
		
		
		try {
			if ($query->execute()) {
				return true;
			}
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	
	function newReferalUser($referalID) {
		include('connect.php');
		$query = $db->prepare("INSERT INTO accounts (referalID, referalKey) VALUES(:referalID, :referalKey)");
		$arr = array(
				'referalID' => $referalID,
				'referalKey' => md5(uniqid('scrolls'))
			);
		
		$this->arrayBinder($query, $arr);
		
		
		try {
			if ($query->execute()) {
				return true;
			}
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	
	function mailSent($mail) {
		include('connect.php');
		$query = $db->prepare("UPDATE betaSignup SET mailsent=1 WHERE mail=:mail");
		$arr = array(
				'mail' => $mail
			); 
		
		$this->arrayBinder($query, $arr);
		
		
		try {
			if ($query->execute()) {
				return true;
			}
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	
	function removeOneKey($userID) {
		include('connect.php');
		$query = $db->prepare("UPDATE accounts SET referalKey=referalKey-- WHERE id=:id");
		$arr = array(
				'id' => $userID
			); 
		
		$this->arrayBinder($query, $arr);
		
		
		try {
			if ($query->execute()) {
				return true;
			}
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
//	function parseCode($txt)
//	{
//	   // these functions will clean the code first
//	   $ret = strip_tags($txt);
//	    
//	   // code replacements
//	   $ret = preg_replace('#\[b\](.+)\[\/b\]#iUs', '<b>$1</b>', $ret);
//	   $ret = preg_replace('#\[link\=(.+)\](.+)\[\/link\]#iUs', '<a href="$1">$2</a>', $ret);
//	   $ret = preg_replace('#\[img\](.+)\[\/img\]#iUs', '<img src="$1" alt="Image" />', $ret); 
//	   $ret = preg_replace('#\[quote\=(.+)\](.+)\[\/quote]#iUs', '<div class="quote">$2</div><div class="quote-by">By: $1</div>', $ret);
//	 
//	    
//	   // return parsed string
//	   return $ret;
//	}

	function findAndReplace($s) {
		$s = preg_replace("#(https?://.+\.mp4)#iUs", '<video controls><source src="$1" type="video/mp4">Your browser does not support the video tag.</video>', $s);
		
		return $s;
	}

	function makeClickableLinks($s) {
		//Line break
		$s = preg_replace('@(\n)@', '</p><p>', $s);
		$s = preg_replace('@(\t)@', '<span class="tab"></span>', $s);
		
//		$s = preg_replace("#([\"'](.+)[\"'])#iUs", '<span class="green">$1</span>', $s);
//		$s = preg_replace("#(===|=>|==|->)#iUs", '<span class="gray">$1</span>', $s);
//		$s = preg_replace("#(var )#iUs", '<span class="purple">$1</span>', $s);
//		$s = preg_replace("#( array|if|function| as|elseif|else|foreach|for|each|return )#iUs", '<span class="blue">$1</span>', $s);
//		$s = preg_replace("#d(true|false)#iUs", '<span class="red">$1</span>', $s);
//		$s = preg_replace("#(//.*\n?)#iUs", '<span class="commentout">$1</span>', $s);
//		$s = preg_replace("#([0-9]+)#iUs", '<span class="red">$1</span>', $s);
//		$s = preg_replace("#([a-zA-z0-9_-]+\(.*\))#iUs", '<span class="red">$1</span>', $s);
//		
//		$s = preg_replace("#($[a-zA-Z0-9]+)#iUs", '<span class="purple">$1</span>', $s);
//		
		$s = preg_replace("#(\[code\](.+)\[/code\])#iUs", "<div class='code'>$2</div>", $s);
		
	
		//$ret = preg_replace('#\[b\](.+)\[\/b\]#iUs', '<b>$1</b>', $ret);
		//text tags
		$bbCode_array = array(
			"b" => "b",
			"em" => "em",
			"h" => "h3",
			"h1" => "h1",
			"h2" => "h2",
			"h3" => "h3",
			
		);
		
		foreach ($bbCode_array as $key => $value) {
			$s = preg_replace("#(\[".$key."\](.+)\[\/".$key."\])#iUs", "<".$value.">$2</".$value.">", $s);
		}
		
		
		//span class
		$bbCodeClass_array = array(
			"money" => "money",
			"s" => "strike"
			
		);
		
		foreach ($bbCodeClass_array as $key => $value) {
			$s = preg_replace("#(\[".$key."\](.+)\[/".$key."\])#iUs", "<span class='".$value."'>$2</span>", $s);
		}
		
		//[code] block syntax highligther
		//purple: 8f73af
		//red: 8c3343
		//green: 5e8a3e
		//bg: 628a2d
		//gray: d4d7de
		//$s = preg_replace('#(/[code/].*[0-9]+.*/[/\code/])#iUs', '<span style="color: #8c3343;">$1</span>', $s);
		
		
		
		
		
		
		
			
		//div class
		$bbCodeDiv_array = array(
			"center" => "align-center",
			"left" => "align-left",
			"right" => "align-right",
			"code" => "code",
			"block-1" => "block-1",
			"block-2" => "block-2",
			"block-3" => "block-3"
			
		);
		
		
		
		foreach ($bbCodeDiv_array as $key => $value) {
			$s = preg_replace("#(\[".$key."\](.+)\[/".$key."\])#iUs", "<div class='".$value."'>$2</div>", $s);
		}
		
		
	
		//icons
		$magin_bottom = "-4px";
		$arr = array(
				'growth' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-growth'></i>",
				'order' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-order'></i>",
				'energy' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-energy'></i>",
				'decay' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-decay'></i>",
				'wild' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-wild'></i>",
				'shard' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-shard'></i>",
				'coin' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-coin'></i>",
				'Adventurer' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-Adventurer'></i>",
				'Adept' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-Adept'></i>",
				'Trickster' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-Trickster'></i>",
				'Sorcerer' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-Sorcerer'></i>",
				'Apprentice-Caller' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-Apprentice-Caller'></i>",
				'Caller' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-Caller'></i>",
				'Accomplished-Caller' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-Accomplished-Caller'></i>",
				'Master-Caller' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-Master-Caller'></i>",
				'Exalted-Caller' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-Exalted-Caller'></i>",
				'Grand-Master' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-Grand-Master'></i>",
				'Aspect-Commander' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-Aspect-Commander'></i>",
				'Ascendant' => "<i style='margin-bottom: ".$magin_bottom.";' class='icon-Ascendant'></i>",
				't' => '<span class="tab"></span>'
				
			);
	
		foreach ($arr as $key => $value) {
			$s = preg_replace("@(\[\/".$key."\])@", $value, $s);
		}


		//link
		$s = preg_replace('@(\[url\=(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)\](.+)\[\/url\])@', '<a href="$2" target="_blank">$8</a>', $s);
		$s = preg_replace('@(\[url\](https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)\[\/url\])@', '<a href="$2" target="_blank">$2</a>', $s);
		
		//img
		$s = preg_replace('@(\[img\](https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)\[\/img\])@', '<img src="$2" alt="$6" />', $s);
		
		//youtube
		
		//<iframe width="640" height="360" src="//www.youtube.com/embed/ES4yNj5LaJY" frameborder="0" allowfullscreen></iframe>

		$s = preg_replace("#\[youtube\]http:\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?[\w\?‌​=]*)?\[\/youtube\]#iUs", '<iframe width="640" height="360" src="//www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>', $s);
		
		$s = preg_replace("#\[youtube\]([a-zA-Z0-9_-]{11})\[\/youtube\]#iUs", '<iframe width="640" height="360" src="//www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>', $s);



		//deck
		
		
		
		

//		if (preg_match("@(\[deck\]([0-9]+)\[\/deck\])@",$s)) {
//			$s = preg_replace('@(\[deck\]([0-9]+)\[\/deck\])@', $this->deckView("ball $2 ball"), $s);
//		}
		
		
		return $s;
	}
	function deckView($id) {
		echo($id."<br />");
		
		
		var_dump($id);
		echo("<br />");
		
		$id = 'tall '.$id.' tall';
		echo($id);
		echo("<br />");
		
		$id = preg_match("(\d+)",$id, $rID);
		var_dump($rID);
		$id = (int)$rID[0];
		
		$html = "";
		include("connect.php");
		$deckData = new deck();
		$query = $db->prepare("SELECT * FROM decks WHERE id = :id");
		$arr = array(
				'id' => $id
			);

		$this->arrayBinder($query, $arr);
		
		
		if($query->execute()){
		$i = 0;
		$row = $query->fetch(PDO::FETCH_ASSOC);
		
		$dataArray = $deckData->getDeckDetails($row['id']);
		$deckType = $dataArray['faction'][0];
		
		$html .= '<div class="div-4" id="'.$id.'">
				  <div class="div-4 classic clearfix '.$deckType.'"  style="margin-bottom: 10px;">
						<a class="" href="'.$main."deck/".$row['id'].'" >
							<div class="header clearfix">
								<h2 class="left clear" style="font-size: 24px;">'.substr($row['deck_title'],0 , 30).'</h2>
							 </div>
						</a>
						<p class="left clear byline">'.$this->ago($row['time']).' ago by '.$row['deck_author'].'with '.$this->totalComments($row['id'], 2).' comment(s) for '.$row['meta'].'</p>';
							
		$html .= '<div class="left clear classicDiv">
						
						<span class="left">';
		
							if ($row['growth'] == 1) {
								$html .= '<i class="icon-growth big" style="margin-bottom: -3px;"></i>';
							}
							
							if ($row['decay'] == 1) {
								$html .= '<i class="icon-decay big" style="margin-bottom: -3px;"></i>';
							}
							
							if ($row['tOrder'] == 1) {
								$html .= '<i class="icon-order big" style="margin-bottom: -3px;"></i>';
							}
							
							if ($row['energy'] == 1) {
								$html .= '<i class="icon-energy big" style="margin-bottom: -3px;"></i>';
							}
							
							if ($row['wild'] == 1) {
								$html .= '<i class="icon-wild big" style="margin-bottom: -3px;"></i>';
							}
							 
		$html .= '</span>
						
						<span class="right white" style="margin-left: 10px;">
							<i class="icon-scrolls"></i> <span>'.$row['scrolls'].'</span>
						</span>
						
						<span class="right white" style="margin-left: 10px;">
							<i class="icon-star"></i> <span>'.$row['vote'].'</span>
						</span>
					</div>
					
					
					<div class="left clear classicDiv white align-center" style="font-size: 12px;">';
					
					
						if (!empty($dataArray['CREATURE'])) {
							$html .= '<span class="">'.$dataArray['CREATURE'].' Creatures</span>';
						}
						
						if (!empty($dataArray['STRUCTURE'])) {
							$html .= '<span>- '.$dataArray['STRUCTURE'].' Structurs</span>';
						}
						
						if (!empty($dataArray['SPELL'])) {
							$html .= '<span>- '.$dataArray['SPELL'].' Spells</span>';
						}
						
						if (!empty($dataArray['ENCHANTMENT'])) {
							$html .= '<span>- '.$dataArray['ENCHANTMENT'].' Enchantments</span>';
						}
						
						
						 
						$total_progress = $dataArray['CREATURE'] + $dataArray['STRUCTURE'] + $dataArray['SPELL'] + $dataArray['ENCHANTMENT'];
						
						$creatureProgess = $dataArray['CREATURE'] / $total_progress * 100;
						$structureProgess = $dataArray['STRUCTURE'] / $total_progress * 100;
						$spellProgess = $dataArray['SPELL'] / $total_progress * 100;
						$enchantProgess = $dataArray['ENCHANTMENT'] / $total_progress * 100;
						
						 
			$html .= '</div>
						<div class="progressbar">
							<div class="bar color-green" style="width: '.$creatureProgess.'%;"></div>
							<div class="bar color-orange" style="width: '.$structureProgess.'%;"></div>
							<div class="bar color-red" style="width: '.$spellProgess.'%;"></div>
							<div class="bar color-blue" style="width: '.$enchantProgess.'%;"></div>
						</div>
					</div>
			</div>';
		
			}		
		
		return $html;
	}
	function getPost($option) {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM scrolls WHERE id=:id");
		$arr = array(
				'id' => $option
			);
		
		$this->arrayBinder($query, $arr);
		
		
		try {
			$query->execute();
			
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				return $row;
			}
			
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function validKey($key, $mail) {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM betaSignup WHERE mail=:mail AND betaKey=:betaKey AND isUsed=0");
		$arr = array(
				'mail' => $mail,
				'betaKey' => $key
			);
		$this->arrayBinder($query, $arr);
		$query->execute();
		
		if ($query->rowCount() === 1) {
			return true;
		} else {
			return false;
		}

	}
	function useKey($mail) {
			include('connect.php');
			$query = $db->prepare("UPDATE betaSignup SET isUsed=1 WHERE mail=:mail");
			$arr = array(
					'mail' => $mail
				);
			$this->arrayBinder($query, $arr);
			$query->execute();
			
			if ($query->rowCount() === 1) {
				return true;
			} else {
				return false;
			}
	
		}
	function newPost($header, $html, $by, $isHidden) {
		include('connect.php');
		$query = $db->prepare("INSERT INTO scrolls (html, byName, header, isHidden) VALUES (:html, :byName, :header, :isHidden)");
		$arr = array(
				'header' => $header,
				'html' => $html,
				'byName' => $by,
				'isHidden' => $isHidden
			);
		
		$this->arrayBinder($query, $arr);
		try {
			$query->execute();
			return true;		
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	
	function totalAccounts() {
		
			include('connect.php');
			$query = $db->prepare("SELECT * FROM accounts");
			$query->execute();
			
			return $query->rowCount();
		
	}
	function totalDecks() {
		
			include('connect.php');
			$query = $db->prepare("SELECT * FROM decks");
			$query->execute();
			
			return $query->rowCount();
		
	}
	function totalFanart() {
		
			include('connect.php');
			$query = $db->prepare("SELECT * FROM fanScrolls");
			$query->execute();
			
			return $query->rowCount();
		
	}
	
	function betaSignup($mail) {
		$key = sha1(microtime().rand());
		include('connect.php');
		$query = $db->prepare("INSERT INTO betaSignup (mail, betaKey) VALUES (:mail, :betaKey)");
		$arr = array(
				'mail' => $mail,
				'betaKey' => $key
			);
		
		$this->arrayBinder($query, $arr);
		try {
			$query->execute();
			return true;		
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function setReadMessage($ign, $type) {
		include('connect.php');
		
			$query = $db->prepare("UPDATE notification SET haveRed=1 WHERE user_id=:toUser AND type = :type AND haveRed=0");
			$arr = array(
					'toUser' => $ign,
					'type' => $type
			);
			$this->arrayBinder($query, $arr);
			
			try {
				if ($query->execute()) {
					return true;
				} else {
					return false;
				}
			} catch (PDOException $e) {
				return(false);
			}
	}
	
	function setNotificationDeck($toUser, $fromUser, $deckID) {
		include('connect.php');
		
			$query = $db->prepare("INSERT INTO notification (user_id, type, text, from_user) VALUES(:toUser, 3, :html, :fromUser)");
			$arr = array(
					'html' => "<a href='".$main."user/".$fromUser."'>".$fromUser."</a> wrote a comment on your <a href='".$main."deck/".$deckID."'>deck</a> ",
					
					
					'toUser' => $toUser,
					'fromUser' => $fromUser
			);
			$this->arrayBinder($query, $arr);
			
			try {
				$query->execute() ? true : false;
			} catch (PDOException $e) {
				return(false);
			}
	}
	
	function setNotificationArt($toUser, $fromUser, $link) {
		include('connect.php');
		
			$query = $db->prepare("INSERT INTO notification (user_id, type, text, from_user) VALUES(:toUser, 3, :html, :fromUser)");
			$arr = array(
					'html' => "<a href='".$main."user/".$fromUser."'>".$fromUser."</a> wrote a comment on your <a href='".$main."fanart/".$link."'>scroll</a> ",
					
					
					'toUser' => $toUser,
					'fromUser' => $fromUser
			);
			$this->arrayBinder($query, $arr);
			
			try {
				$query->execute() ? true : false;
			} catch (PDOException $e) {
				return(false);
			}
	}
	
	function setNotificationPost($toUser, $fromUser, $id) {
		include('connect.php');
		
			$query = $db->prepare("INSERT INTO notification (user_id, type, text, from_user) VALUES(:toUser, 3, :html, :fromUser)");
			$arr = array(
					'html' => "<a href='".$main."user/".$fromUser."'>".$fromUser."</a> wrote a comment on your <a href='".$main."post/".$id."'>spoiler post</a> ",
					
					
					'toUser' => $toUser,
					'fromUser' => $fromUser
			);
			$this->arrayBinder($query, $arr);
			
			try {
				$query->execute() ? true : false;
			} catch (PDOException $e) {
				return(false);
			}
	}
	function setNotificationReply($toUser, $fromUser, $link, $type) {
		include('connect.php');
		
			$query = $db->prepare("INSERT INTO notification (user_id, type, text, from_user) VALUES(:toUser, 3, :html, :fromUser)");
			$arr = array(
					'html' => "<a href='".$main."user/".$fromUser."'>".$fromUser."</a> wrote a comment on a <a href='".$link."'>".$type."</a> you commented on.",
					
					
					'toUser' => $toUser,
					'fromUser' => $fromUser
			);
			$this->arrayBinder($query, $arr);
			
			try {
				$query->execute() ? true : false;
			} catch (PDOException $e) {
				return(false);
			}
	}
	
	function notfiCount($name) {
		include('connect.php');
		$query = $db->prepare("SELECT id FROM notification WHERE user_id=:ign AND haveRed = 0");
		$arr = array(
				'ign' => $name
			);
		$this->arrayBinder($query, $arr);
		$query->execute();
		
		return $query->rowCount();
	}
	
	function totalComments($id, $cWhere=1) {
		include('connect.php');
		$query = $db->prepare("SELECT id FROM comment WHERE commentToID=:id AND cWhere=:cWhere");
		$arr = array(
				'id' => $id,
				'cWhere' => $cWhere
			);
		$this->arrayBinder($query, $arr);
		$query->execute();
		return $query->rowCount();
	}
	function delComment($id, $user) {
		include('connect.php');
		
		$Uquery = $db->prepare("SELECT * FROM accounts WHERE ign=:ign");
		$Uarr = array(
				'ign' => $user
			);
		$this->arrayBinder($Uquery, $Uarr);
		
		$Cquery = $db->prepare("SELECT * FROM comment WHERE id=:id");
		$Carr = array(
				'id' => $id
			);
		$this->arrayBinder($Cquery, $Carr);
		
		
			if ($Cquery->execute()) {	
				if ($Uquery->execute()) {
					
					$u = $Uquery->fetch(PDO::FETCH_ASSOC);
					$comment = $Cquery->fetch(PDO::FETCH_ASSOC);
					
					if (($comment['byUser'] == $user) || ($u['rank']) < 3) {
						$query = $db->prepare("DELETE FROM comment where id = :id");
						$arr = array(
								'id' => $id
							);
						
						$this->arrayBinder($query, $arr);
						$query->execute();
					}
					
				}
				
			}
		}

	function tof($i) {
		if ($i == 0) {
			return false;
		} else {
			return true;
		}
	}
	
	function canEditGuild($user, $gid, $gl) {
		
		include('connect.php');
		$query = $db->prepare("
			SELECT * FROM guildMembers
			JOIN premitions
			ON guildMembers.rankID = premitions.id
			WHERE guildMembers.user_id = :name");
		$arr = array(
				'name' => $user
			);
		$this->arrayBinder($query, $arr);
		$query->execute();
		
		$row = $query->fetch(PDO::FETCH_ASSOC);
		
		if ( 
		   (($this->tof($row['allow_edit_badge']) ||
			$this->tof($row['allow_edit_desc']) ||
			$this->tof($row['allow_edit_flair']) ||
			$this->tof($row['allow_members_kick']) ||
			$this->tof($row['allow_update_score']) ||
			$this->tof($row['allow_edit_rating']) ||
			$this->tof($row['allow_edit_premitions']) ||
			$this->tof($row['allow_edit_leader']) ||
			$this->tof($row['allow_guildwide_message']) ||
			$this->tof($row['allow_recruit_form']) )
			&&
			($this->getGuildID2($user) == $gid)) ||
			$gl == $user
			 ) {
			
			return true;
			
		} else {
		
			return false;
			
		}
	}
	function canInviteToGuild($user, $gid, $gl) {
		
		include('connect.php');
		$query = $db->prepare("
			SELECT * FROM guildMembers
			JOIN premitions
			ON guildMembers.rankID = premitions.id
			WHERE guildMembers.user_id = :name");
		$arr = array(
				'name' => $user
			);
		$this->arrayBinder($query, $arr);
		$query->execute();
		
		$row = $query->fetch(PDO::FETCH_ASSOC);
		
		if ( ($this->tof($row['allow_members_invite']) && ($this->getGuildID2($user) == $gid)) ||$gl == $user ) {
			
			return true;
			
		} else {
		
			return false;
			
		}
	}
	function canEditGuild2($user) {
		
		include('connect.php');
		$query = $db->prepare("
			SELECT * FROM guildMembers
			JOIN premitions
			ON guildMembers.rankID = premitions.id
			WHERE guildMembers.user_id = :name");
		$arr = array(
				'name' => $user
			);
		$this->arrayBinder($query, $arr);
		$query->execute();
		
		$row = $query->fetch(PDO::FETCH_ASSOC);
		
		if ( 
		    $this->tof($row['allow_edit_badge']) ||
			$this->tof($row['allow_members_invite']) ||
			$this->tof($row['allow_edit_desc']) ||
			$this->tof($row['allow_edit_flair']) ||
			$this->tof($row['allow_members_kick']) ||
			$this->tof($row['allow_update_score']) ||
			$this->tof($row['allow_edit_rating']) ||
			$this->tof($row['allow_edit_premitions']) ||
			$this->tof($row['allow_edit_leader']) ||
			$this->tof($row['allow_guildwide_message']) ||
			$this->tof($row['allow_recruit_form'])
			)
			{
			
				return true;
			
			} else {
			
				return false;
				
			}
	}
	function canInviteToGuild2($user) {
		
		include('connect.php');
		$query = $db->prepare("
			SELECT * FROM guildMembers
			JOIN premitions
			ON guildMembers.rankID = premitions.id
			WHERE guildMembers.user_id = :name");
		$arr = array(
				'name' => $user
			);
		$this->arrayBinder($query, $arr);
		$query->execute();
		
		$row = $query->fetch(PDO::FETCH_ASSOC);
		
		if ($this->tof($row['allow_members_invite'])) {
			
				return true;
			
			} else {
			
				return false;
				
			}
	}
	function getRankName($id) {
			include('connect.php');
			$query = $db->prepare("SELECT rank_name FROM premitions WHERE id=:id");
			$arr = array(
					'id' => $id
				);
			$this->arrayBinder($query, $arr);
			$query->execute();
			$row = $query->fetch(PDO::FETCH_ASSOC);
			if (!empty($row['rank_name'])) {
				return $row['rank_name'];
			} else {
				return "Not set";
			}
			
			
		
	}
	function delGuildInvite($id) {
		include('connect.php');
		$query = $db->prepare("DELETE FROM notification where id = :id");
		$arr = array(
				'id' => $id
			);
		
		$this->arrayBinder($query, $arr);
		try {
			if ($query->execute()) {
				return true;
			} else {
				return false;
			}
						
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	function delPost($id) {
		include('connect.php');
		$query = $db->prepare("DELETE FROM scrolls where id = :id");
		$arr = array(
				'id' => $id
			);
		
		$this->arrayBinder($query, $arr);
		try {
			$query->execute();
						
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	
	function login($username, $password) {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM accounts WHERE ign=:username AND password=:password");
		$arr = array(
				'username' => $username,
				'password' => sha1($password)
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			$query->execute();
			
			if ($query->rowCount() === 1) {
				$row = $query->fetch(PDO::FETCH_ASSOC);
				$_SESSION['username'] = $row['ign'];
				$_SESSION['rank'] = $row['rank'];
				$_SESSION['headID'] = $row['headID'];
				
				
			} else {
				$_GET['error'] = "Wrong login information";
				if (isset($_GET['success'])) {
					unset($_GET['success']);
				}	
			};
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
		
		
	}
	
	
	function authLogin($username, $token) {
		include('connect.php');
		$query = $db->prepare("SELECT * FROM accounts WHERE ign=:username AND betaKey=:token");
		$arr = array(
				'username' => $username,
				'token' => $token
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			$query->execute();
			
			if ($query->rowCount() === 1) {
				$row = $query->fetch(PDO::FETCH_ASSOC);
				$_SESSION['username'] = $row['ign'];
				$_SESSION['rank'] = $row['rank'];
				$_SESSION['headID'] = $row['headID'];
				
				
			} else {
				$_GET['error'] = "Wrong login information";
				if (isset($_GET['success'])) {
					unset($_GET['success']);
				}	
			};
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
		
	}
	
	function logout() {
		unset($_SESSION['username']);
		unset($_SESSION['rank']);
		unset($_SESSION['headID']);
		
		unset($_COOKIE['scrolldier_usernmae']);
		unset($_COOKIE['scrolldier_password']);
		
		setcookie('scrolldier_usernmae', null, -1, '/');
		setcookie('scrolldier_token', null, -1, '/');
		
		session_destroy();
		
		header("location: index.php");
	}

	function editPost($id, $header, $html, $by, $isHidden) {
		include('connect.php');
	
		
		$query = $db->prepare("UPDATE scrolls SET html=:html, header=:header, byName=:byName, isHidden=:isHidden WHERE id=:id");
		$arr = array(
				'id' => $id,
				'html' => $html,
				'header' => $header,
				'byName' => $by,
				'isHidden' => $isHidden
			);
		
		$this->arrayBinder($query, $arr);
		
		try {
			$query->execute();
			return $query;
		} catch (PDOException $e) {
			return($this->errorHandle($e));
		}
	}
	
	function hasDonated($ign) {
			include('connect.php');
			$query = $db->prepare("SELECT * FROM accounts WHERE ign=:ign");
			$arr = array(
					'ign' => $ign
				);
			
			$this->arrayBinder($query, $arr);
			
			
			try {
				$query->execute();
				$row = $query->fetch(PDO::FETCH_ASSOC);
				if ($row['hasDonated'] == 1) {
					return true;
				} else {
					return false;
				}
				
			} catch (PDOException $e) {
				return($this->errorHandle($e));
			}
	}
	
	function changePassword($pw, $id) {
		include('connect.php');
	
		$query = $db->prepare("UPDATE accounts SET password=:password WHERE id=:id");
		$arr = array(
				'id' => $id,
				'password' => sha1($pw)
		);
		$this->arrayBinder($query, $arr);
		
		try {
			if ($query->execute()) {
				return true;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			return(false);
		}
	}
	function updatePlayerHead($ign) {
		$url = "http://a.scrollsguide.com/player?name=".$ign."&avatar";
		$json = file_get_contents($url);
		$data = json_decode($json, TRUE);
		if ($data['msg'] == "success") { 
			$headID = $data['data']['avatar'][0]['head'];
			$bodyID = $data['data']['avatar'][0]['body'];
			$legsID = $data['data']['avatar'][0]['leg'];
			$armRightID = $data['data']['avatar'][0]['armback'];
			$armLeftID = $data['data']['avatar'][0]['armfront'];
			
			include('connect.php');
			
				$query = $db->prepare("UPDATE accounts SET headID=:headID, bodyID=:bodyID, legsID=:legsID, arm_rightID=:armRightID, arm_leftID=:armLeftID WHERE ign=:ign");
				$arr = array(
						'headID' => $headID,
						'bodyID' => $bodyID,
						'legsID' => $legsID,
						'armRightID' => $armRightID,
						'armLeftID' => $armLeftID,
						
						'ign' => $ign
				);
				$this->arrayBinder($query, $arr);
				
				try {
					if ($query->execute()) {
						return true;
					} else {
						return false;
					}
				} catch (PDOException $e) {
					return(false);
				}
		} else {
			return false;
		}
	}
	function AddBB($var) { 
	        $search = array( 
	                '/\[b\](.*?)\[\/b\]/is', 
	                '/\[i\](.*?)\[\/i\]/is', 
	                '/\[u\](.*?)\[\/u\]/is', 
	                '/\[img\](.*?)\[\/img\]/is', 
	                '/\[url\](.*?)\[\/url\]/is', 
	                '/\[url\=(.*?)\](.*?)\[\/url\]/is' 
	                ); 
	
	        $replace = array( 
	                '<strong>$1</strong>', 
	                '<em>$1</em>', 
	                '<u>$1</u>', 
	                '<img src="$1" />', 
	                '<a href="$1">$1</a>', 
	                '<a href="$1">$2</a>' 
	                ); 
	
	        $var = preg_replace ($search, $replace, $var); 
	        return $var; 
	}
	
	
	function ago($datetime, $full=false)
	{
	   	   $now = new DateTime;
	       $ago = new DateTime($datetime);
	       $diff = $now->diff($ago);
	   
	       $diff->w = floor($diff->d / 7);
	       $diff->d -= $diff->w * 7;
	   
	       $string = array(
	           'y' => 'year',
	           'm' => 'month',
	           'w' => 'week',
	           'd' => 'day',
	           'h' => 'hour',
	           'i' => 'minute',
	           's' => 'second',
	       );
	       foreach ($string as $k => &$v) {
	           if ($diff->$k) {
	               $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	           } else {
	               unset($string[$k]);
	           }
	       }
	   
	       if (!$full) $string = array_slice($string, 0, 1);
	       return $string ? implode(', ', $string) : 'just now';
	 }
	 function dayAgo($datetime)
	 {
	    	$now = new DateTime;
	        $ago = new DateTime($datetime);
	        $diff = $now->diff($ago);
	        
	        return $this->seconds_from_time($diff);
	    
	  }
	  
	  function seconds_from_time($time) { 
	      list($h, $m, $s) = explode(':', $time); 
	      return ($h * 3600) + ($m * 60) + $s; 
	  } 
	  
	  
	  function time_from_seconds($seconds) { 
	      $h = floor($seconds / 3600); 
	      $m = floor(($seconds % 3600) / 60); 
	      $s = $seconds - ($h * 3600) - ($m * 60); 
	      return sprintf('%02d:%02d:%02d', $h, $m, $s); 
	  } 
	  
	  
	function daysAgo($time)
	{
	   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	   $lengths = array("60","60","24","7","4.35","12","10");
	
	   $now = time();
	
	       $difference     = $now - $time;
	       $tense         = "ago";
	
	   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
	       $difference /= $lengths[$j];
	   }
	
	   $difference = round($difference);
	
	   if($difference != 1) {
	       $periods[$j].= "s";
	   }
	
	   return "$difference $periods[$j] 'ago' ";
	}

}