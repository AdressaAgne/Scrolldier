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
	function delComment($id) {
		include('connect.php');
		$query = $db->prepare("DELETE FROM comment where id = :id");
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
	
	function logout() {
		unset($_SESSION['username']);
		unset($_SESSION['rank']);
		unset($_SESSION['headID']);
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