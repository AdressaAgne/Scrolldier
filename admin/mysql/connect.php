<?php 

//
$db_host = "localhost";
$db_username = "root";
$db_password = "root";
$db_name = "orangee_test";

$db = new PDO('mysql:host='.$db_host.';dbname='.$db_name,$db_username,$db_password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
