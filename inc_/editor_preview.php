<?php 
	include('../admin/mysql/connect.php');
	include('../admin/mysql/function.php');
	$x = new xClass();
	echo($x->makeClickableLinks($x->findAndReplace(strip_tags($_POST['html']))));
