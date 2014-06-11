<?php
header ('Content-Type: image/png');

$url = "http://a.scrollsguide.com/player?name=".$_GET['user']."&avatar";
$json = file_get_contents($url);
$data = json_decode($json, TRUE);


function frontHandId($i) {
	$ids = array(
		3 => 3,
		81 => 30,
		80 => 80,
		4 => 21,
		99 => 99,
		97 => 97,
		146 => 146,
		145 => 145,
		78 => 78,
		96 => 96,
		94 => 94,
		7 => 7,
		1 => 15,
		79 => 79,
		95 => 95,
		98 => 110,
		100 => 107,
		5 => 19
	);
	if (array_key_exists($i, $ids)) {
		return $ids[$i];
	} else {
		return $data['data']['avatar'][0]['armfront'];
	}
	
}

function offset($i) {
	$ids = array(
		95 => 110
	);
	if (array_key_exists($i, $ids)) {
		return $ids[$i];
	} else {
		return 0;
	}
	
}

$width = 567+offset($data['data']['avatar'][0]['armback']);
$height = 991;

$bg = imagecreatefrompng("../resources/bg.png");
$armback = imagecreatefrompng("../resources/back_arm_".$data['data']['avatar'][0]['armback'].".png");

$body = imagecreatefrompng("../resources/body_".$data['data']['avatar'][0]['body'].".png");

$leg = imagecreatefrompng("../resources/legs_".$data['data']['avatar'][0]['leg'].".png");

$head = imagecreatefrompng("../resources/head_".$data['data']['avatar'][0]['head'].".png");

$armfront = imagecreatefrompng("../resources/front_arm_".frontHandId($data['data']['avatar'][0]['armback']).".png");



imagealphablending($bg, true);
imagesavealpha($bg, true);

imagecopy($bg, $armback, offset($data['data']['avatar'][0]['armback']), 0, 0, 0, $width, $height);
imagecopy($bg, $leg, offset($data['data']['avatar'][0]['armback']), 0, 0, 0, $width, $height);
imagecopy($bg, $body, offset($data['data']['avatar'][0]['armback']), 0, 0, 0, $width, $height);
imagecopy($bg, $armfront, 0, 0, 0, 0, $width, $height);
imagecopy($bg, $head, offset($data['data']['avatar'][0]['armback']), 0, 0, 0, $width, $height);
imagepng($bg);

imagedestroy($bg);
imagedestroy($armback);
imagedestroy($body);
imagedestroy($leg);
imagedestroy($head);
imagedestroy($armfront);

?>