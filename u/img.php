<?php
header ('Content-Type: image/png');


$url = "http://a.scrollsguide.com/player?name=".$_GET['user']."&achievements&fields=all&avatar";
$json = file_get_contents($url);
$data = json_decode($json, TRUE);


if ($data['msg'] == "success") {

$userStats['name'] = $data['data']['name'];
$userStats['rating'] = $data['data']['rating'];

$userStats['rank'] = $data['data']['rank'];
$userStats['badge'] = $data['data']['badgerank'];
$userStats['played'] = $data['data']['played'];
$userStats['ranked'] = $data['data']['rankedwon'];
$userStats['judgment'] = $data['data']['limitedwon'];
$userStats['won'] = $data['data']['won'];
$userStats['surrendered'] = $data['data']['surrendered'];
$userStats['gold'] = $data['data']['gold'];
$userStats['scrolls'] = $data['data']['scrolls'];
$userStats['lastgame'] = $data['data']['lastgame'];
$userStats['lastupdate'] = $data['data']['lastupdate'];


if ($data['data']['rating'] > 1500) {
	$userStats['decay'] = intval((($data['data']['rating']) - 1500)*0.05);
} else {
	$userStats['decay'] = 0;
}

$userStats['lost'] = ($userStats['played'] - $userStats['won'] - $userStats['surrendered']);



$userStats['ratio'] = round($userStats['won'] / $userStats['played'] * 100, 1);
	
}

$im = @imagecreatetruecolor(400, 100) or die('Cannot Initialize new GD image stream');


$bgColor = imagecolorallocate($im, 18, 19, 20);
 
      
$header_color = imagecolorallocate($im, 228, 218, 188);
$text_color = imagecolorallocate($im, 248, 248, 248);



$header_font = "font.ttf";
$font = "os.ttf";
$text = $userStats['name'];

$header_fontsize = 30;
$fontsize = 14;

imagefill($im, 0, 0, $bgColor);

imagettftext($im, $header_fontsize, 0, 10, 35, $header_color, $header_font, $text);
imagettftext($im, $fontsize, 0, 10, 65, $text_color, $font, "Rank: ".$userStats['rank']." - "."Rating: ".$userStats['rating']);
imagettftext($im, $fontsize, 0, 10, 85, $text_color, $font, "Played: ".$userStats['played']." - " . "Won: ".$userStats['won']." (".$userStats['ratio']."%)");

imagepng($im);
imagedestroy($im);
imagedestroy($dest);
imagedestroy($src);


?>