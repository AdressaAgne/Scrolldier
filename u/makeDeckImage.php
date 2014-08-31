<?php
include('../admin/mysql/connect.php');
include('../admin/mysql/function.php');
$x = new xClass();
header ('Content-Type: image/png');
set_time_limit(5000);
	function get_file_extension($file_name) {
		return substr(strrchr($file_name,'.'),1);
	}

	
	$query = $db->prepare("SELECT * FROM decks WHERE id=:id");
	$arr = array(
			'id' => $_GET['d']
		);
	
	$x->arrayBinder($query, $arr);
	$query->execute();		
	$row = $query->fetch(PDO::FETCH_ASSOC);

	$listOfScrolls = array();			
	$json = $row['JSON'];
	$data = json_decode($json, TRUE);
	if ($data['msg'] == "success") { 
		
		
		
		for ($i = 0; $i < count($data['data']['scrolls']); $i++) {
		
			$query = $db->prepare("SELECT * FROM scrollsCard WHERE id=:id");
			$arr = array(
					'id' => $data['data']['scrolls'][$i]['id']
				);
			
			$x->arrayBinder($query, $arr);
			$query->execute();		
			$card = $query->fetch(PDO::FETCH_ASSOC);
		  
		  
		  	$scrollsCost = 0;
		  	$scrollType = "";
		  	
		  	if (!empty($card['costorder'])) {
		  		
		  		$scrollsCost = $card['costorder'];
		  		$scrollType = "order";
		  		
		  	} elseif (!empty($card['costgrowth'])) {
		  	
		  		$scrollsCost = $card['costgrowth'];	
		  		$scrollType = "growth";
		  		
		  	} elseif (!empty($card['costenergy'])) {
		  	
		  		$scrollsCost = $card['costenergy'];
		  		$scrollType = "energy";
		  	
		  	}elseif (!empty($card['costdecay'])) {
		  	
		  		$scrollsCost = $card['costdecay'];
		  		$scrollType = "decay";
		  		
		  	}
		  
		  	$singelScroll = array(
		  		2 => $scrollsCost,
		  		3 => $card['image'],
		  		4 => $data['data']['scrolls'][$i]['c'],
		  		5 => $card['name'],
		  		6 => $scrollType,
		  		7 => 0,
		  		8 => 0,
		  		9 => $card['description'],
		  		10 => $card['passiverules_1'],
		  		11 => $card['passiverules_2'],
		  		12 => $card['passiverules_3'],
		  		13 => $card['types'],
		  		14 => $card['kind'],
		  		15 => $card['id']
		  		
		  	);
		  
		  	array_push($listOfScrolls, $singelScroll);
		  
		}
	} 
	function my_sort($a,$b) {
	if ($a==$b) return 0;
	   return ($a<$b)?-1:1;
	}
					
					
	usort($listOfScrolls, "my_sort");

	function getRType($i) {
		$scroll = array(
		 "decay" => "scroll/256_decay_result.png",
		 "energy" => "scroll/256_energy_result.png",
		 "growth" => "scroll/256_growth_result.png",
		 "order" => "scroll/256_order_result.png"
		);
		return $scroll[$i];
	}
	
	$iw = 100;
	$ih = $iw*.75;
	
	$imagesPerRow = 1;
	
	$path = '../resources/cardImages/';
	$query = $db->prepare("SELECT * FROM decks WHERE id=:id");
	$arr = array(
			'id' => $_GET['d']
		);
	$x->arrayBinder($query, $arr);
	$query->execute();		
	$row = $query->fetch(PDO::FETCH_ASSOC);
	

	
		
	if ($handle = opendir($path)) {
		$files = scandir($path);
		$NUM_IMAGES = count($files) - 2;
 
		$width = $imagesPerRow * $iw;
		$height = ceil($NUM_IMAGES / $imagesPerRow) * $ih;

		$wallpaper = imagecreatetruecolor(678, $ih*count($listOfScrolls));
		
		$c = 0;
		$gradientBG = imagecreatefrompng("deckImage/bg1.png");
		$curveBG = imagecreatefrompng("deckImage/curveBG.png");
		
		
		$font = "os.ttf";
		$color = imagecolorallocate($wallpaper, 248, 248, 248);
		
		$orderDecay = imagecolorallocate($wallpaper, 173, 127, 204);
		$orderGrowth = imagecolorallocate($wallpaper, 160, 204, 86);
		$orderEnergy = imagecolorallocate($wallpaper, 204, 149, 0);
		$orderOrder = imagecolorallocate($wallpaper, 148, 178, 204);
		
		$fontSize = 25;
		
	
		
	for ($j = 0; $j < count($listOfScrolls); $j++) {
			$imgFile = $path . $listOfScrolls[$j][3].".png";
 
			$i = imagecreatefrompng($imgFile);
			
			list($fileId) = explode(".", $imgFile);
			
			$sw = imagesx($i);
			$sh = imagesy($i);
			
			$row = floor($c / $imagesPerRow);
			$col = $c % $imagesPerRow;
			
			$dx = $col * $iw;
			$dy = $row * $ih;
			$typeIcon = imagecreatefrompng(getRType($listOfScrolls[$j][6]));
			
			imagecopyresampled($wallpaper, $gradientBG, $dx, $dy, 0, 0, 678, 88, 678, 88);
			imagecopyresampled($wallpaper, $i, $dx+550, $dy, 0, 0, $iw, $ih, $sw, $sh);
			
			$textOffset = $dy + $fontSize*2;
			
			imagecopyresampled($wallpaper, $typeIcon, 10, $dy+10, 0, 0, 64, 64, 256, 256);
			
			imagettftext($wallpaper, $fontSize, 0, 84, $textOffset, $color, $font, $listOfScrolls[$j][2]);
			
			imagettftext($wallpaper, $fontSize, 0, 124, $textOffset, $color, $font, $listOfScrolls[$j][5]);
			
			imagettftext($wallpaper, $fontSize, 0, 500, $textOffset, $color, $font, "x".$listOfScrolls[$j][4]);
			$c++;
		}
		
		closedir($handle);
		
		imagepng($wallpaper);
		
		imagedestroy($wallpaper);
	}