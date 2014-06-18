<?php
include('../admin/mysql/connect.php');
include('../admin/mysql/function.php');
$xClass = new xClass();
header ('Content-Type: image/png');
session_start();


$width = 512;
$height = 1088;




function getBack($type, $rarity = 0) {
	$scroll = array(
	 "scroll/scrolls__scrollbase_neutral_".$rarity.".png",
	 "scroll/scrolls__scrollbase_energy_".$rarity."_result.png",
	 "scroll/scrolls__scrollbase_growth_".$rarity."_result.png",
	 "scroll/scrolls__scrollbase_order_".$rarity."_result.png",
	 "scroll/scrolls__scrollbase_Wild_".$rarity."_result.png",
	 "scroll/scrolls__scrollbase_Chaos_".$rarity."_result.png"
	);
	
	return $scroll[$type];
}

function getOverlay($i) {
	return "scroll/scrolls__scrollbase_colorizarion_layer_".$i.".png";
}

function getBackSize($i) {
	$scroll = array(
	 512,
	 512,
	 512,
	 512,
	 633,
	 633
	);
	
	return $scroll[$i];
}


$type = 0;
$tier = 0;

$r = 4;
$g = 0;
$b = 0;

$bg = imagecreatefrompng("../resources/bg.png");

$scroll = imagecreatefrompng(getBack($type, $tier));





//set the natural scroll background
if ($type == 0) {
	imagecopyresampled($bg, $scroll, 0, 0, 0, 0, 950*.59, 950, 633, 1024);
} else {
	imagecopyresampled($bg, $scroll, 0, 0, 0, 0, 950*.59, 950, 512, 1024);
}



$overlay = imagecreatefrompng(getOverlay($tier));
//change color of image
/* RGB of your inside color */
$rgb = array($r,$g,$b);
/* Your file */

/* Negative values, don't edit */
$rgb = array(255-$rgb[0],255-$rgb[1],255-$rgb[2]);
imagealphablending( $overlay, false );
imagesavealpha( $overlay, true );

imagefilter($overlay, IMG_FILTER_NEGATE); 
imagefilter($overlay, IMG_FILTER_COLORIZE, $rgb[0], $rgb[1], $rgb[2]); 
imagefilter($overlay, IMG_FILTER_NEGATE); 

//set faction overlay
imagecopyresampled($bg, $overlay, 0, 0, 0, 0, 950*.59, 950, 633, 1024);

//output image
imagepng($bg);

//destroy image leaks
imagedestroy($bg);

	


?>