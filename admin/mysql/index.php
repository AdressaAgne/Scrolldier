<?php
//$query = $db->query("SELECT comment FROM comment");

//while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//	print($prefix.$row['comment'].$sufix);
//}

include('connect.php');
include_once('function.php');

$x = new xClass();
echo("<br />editOption; ");
$x->editOption('footer', '<p class="byline align-center copyright"><small>© Agne Ødegaard, © Orangee - 2013</small></p>');

echo("<br />getOption print_r(); ");
print_r($x->getOption('contact_mail'));

echo("<br />getOption echo; ");
$string = $x->getOption('footer');
echo($string['content_text']);

echo("<br />mySQL PDO query: ");



$query = $db->prepare("SELECT * FROM options WHERE option_id=:id");
$arr = array(
		'id' => 'footer'
	);

$x->arrayBinder($query, $arr);

try {
	$query->execute();
	
} catch (PDOException $e) {
	echo $x->errorHandle($e);
}

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
	echo($row['content_text']);
}


