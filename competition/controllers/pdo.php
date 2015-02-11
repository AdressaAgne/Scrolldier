<?php 

class Database {
	
	protected $_db_host;
	protected $_db_username;
	protected $_db_password;
	protected $_db_name;
	public $_db;
	
	function __construct() {
		
		$this->_db_host = "localhost";
		$this->_db_username = "root";
		$this->_db_password = "root";
		$this->_db_name = "orangee_test";
		
//$db_host = "scrolldier.com.mysql";
//$db_username = "scrolldier_com";
//$db_password = "wDtvKMgE";
//$db_name = "scrolldier_com"
			
		try {
			$this->_db = new PDO('mysql:host='.$this->_db_host.';dbname='.$this->_db_name, $this->_db_username, $this->_db_password);
			$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		} catch (PDOException $e) {
			
			$_GET['error'] .= "\n".$e;
			
		}
	}
	
	
	public function arrayBinder(&$pdo, &$array) {
		foreach ($array as $key => $value) {
			$pdo->bindValue(':'.$key,$value);
		}
	}
	
	
	public function arrayBinderInt(&$pdo, &$array) {
		foreach ($array as $key => $value) {
			$pdo->bindValue(':'.$key, (int) $value, PDO::PARAM_INT);
		}
	}
	
}
