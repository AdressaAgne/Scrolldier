<?php
header ('Content-Type: image/png');
set_time_limit(5000);
	function get_file_extension($file_name) {
		return substr(strrchr($file_name,'.'),1);
	}

	$iw = 100;
	$ih = $iw*.75;
	
	$imagesPerRow = 20;
	
	$path = '../resources/cardImages/';
	
	
	
	if ($handle = opendir($path)) {
		$files = scandir($path);
		$NUM_IMAGES = count($files) - 2;
 
		$width = $imagesPerRow * $iw;
		$height = ceil($NUM_IMAGES / $imagesPerRow) * $ih;
	
		$wallpaper = imagecreatetruecolor($width, $height);
		
		$c = 0;
		
		while (false !== ($file = readdir($handle))) {
			if (get_file_extension($file) != "png") continue;
 
			$i = imagecreatefrompng($path . $file);
			
			list($fileId) = explode(".", $file);
			
			$sw = imagesx($i);
			$sh = imagesy($i);
			
			$row = floor($c / $imagesPerRow);
			$col = $c % $imagesPerRow;
			
			$dx = $col * $iw;
			$dy = $row * $ih;
			
			imagecopyresampled($wallpaper, $i, $dx, $dy, 0, 0, $iw, $ih, $sw, $sh);
			
			$c++;
		}
		
		closedir($handle);
		
		imagepng($wallpaper);
		
		imagedestroy($wallpaper);
	}