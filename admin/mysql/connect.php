<?php 

$main = "http://$_SERVER[HTTP_HOST]/";
//
$db_host = "localhost";
$db_username = "root";
$db_password = "root";
$db_name = "orangee_test";

//$db_host = "scrolldier.com.mysql";
//$db_username = "scrolldier_com";
//$db_password = "wDtvKMgE";
//$db_name = "scrolldier_com";



try {
	$db = new PDO('mysql:host='.$db_host.';dbname='.$db_name,$db_username,$db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
	header("location:".$main."error");
}
	


 ?>