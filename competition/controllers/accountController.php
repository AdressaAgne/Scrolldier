<?php 
class AccountController extends Database {
	
	
	public function login($username, $password, $remember, $use_token = false) {
		
		if ($use_token) {
			$query = $this->_db->prepare("SELECT * FROM accounts WHERE username = :username AND token = :token");
			$arr = array(
			    'username' => $username,
			    'token' => $password
			);
			$this->arrayBinder($query, $arr);
		} else {
			$query = $this->_db->prepare("SELECT * FROM accounts WHERE username = :username AND password = :password");
			$arr = array(
			    'username' => $username,
			    'password' => sha1($password)
			);
			$this->arrayBinder($query, $arr);
		}
		
		
		if ($query->execute()) {
			$row = $query->fetch(PDO::FETCH_ASSOC);
			
			$user = new Account();
			
			$user->username = $row['username'];
			$user->rank = $row['rank'];
			$user->donor = $row['donor'];
			$user->mail = $row['mail'];
			$user->main_confirmed = $row['main_confirmed'];
			
			$_SESSION['username'] = $row['username'];
			
			if ($remember) {
				$expire=time()+60*60*24*30;
				setcookie("remember_user", true, $expire);
				setcookie("scrolldier_usernmae", $row['username'], $expire);
				setcookie("scrolldier_token", $row['token'], $expire);
			}
			
			return $user;
		}
		
		
	}
	
	public function logout() {
		unset($_SESSION['username']);
		
		setcookie('scrolldier_usernmae', null, -1, '/');
		setcookie('scrolldier_token', null, -1, '/');
		
		unset($_COOKIE['scrolldier_usernmae']);
		unset($_COOKIE['scrolldier_token']);
		
		session_destroy();
	}
	
}

class Account {
	
	public $username = "";
	
	public $rank = 0;
	
	public $donor = false;
	
	public $mail = "";
	
	public $main_confirmed = false;
	
	
}