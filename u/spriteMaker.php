<?php
header ('Content-Type: image/png');
set_time_limit(5000);




function get_file_extension($file_name) {
	return substr(strrchr($file_name,'.'),1);
}



//$dir = '../resources/cardImages/spoilerArt/';
$dir = '../resources/cardImages/';
$files = scandir($dir);

for ($i = 0; $i < count($files); $i++) {
	if (get_file_extension($files[$i]) != "png") {
		unset($files[$i]);
	}
}


$files = array_values($files);
$imageCount = count($files);
$w = 100;
$h = $w*.75;
$y = 0;
$break = round(sqrt(count($files)), PHP_ROUND_HALF_UP);



$bg = @imagecreatetruecolor($break*$w, $break*$h)
    or die("Cannot Initialize new GD image stream");



//print_r($files);

for ($i = 0; $i < $imageCount; $i++) {
	$key = $i;
	
	if (get_file_extension($files[$key]) == "png") {
	
	for ($j = 0; $j < $imageCount/$break; $j++) {
		
		if ($key >= $break*$j) {
			$y2 = $h*$j;
			$x = 100*($i-($break*$j));	
			
			$img = imagecreatefrompng($dir.$files[$key]);
			imagecopyresampled($bg, $img, $x, $y2, 0, 0, $w, $h, 300, 225);
			imagedestroy($img);
			
		} else {
			$y2 = 0;
			$x = 100*$i;
			
			$img = imagecreatefrompng($dir.$files[$key]);
			imagecopyresampled($bg, $img, $x, $y2, 0, 0, $w, $h, 300, 225);
			imagedestroy($img);

		}
		
	}
	
	}
	
}


imagepng($bg);

imagedestroy($bg);


?>