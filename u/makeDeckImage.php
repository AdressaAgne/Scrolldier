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
	$curveO = array(
		1 => intval(0),
		2 => intval(0),
		3 => intval(0),
		4 => intval(0),
		5 => intval(0),
		6 => intval(0),
		7 => intval(0),
		8 => intval(0),
		9 => intval(0)
	);
	$curveG = array(
		1 => intval(0),
		2 => intval(0),
		3 => intval(0),
		4 => intval(0),
		5 => intval(0),
		6 => intval(0),
		7 => intval(0),
		8 => intval(0),
		9 => intval(0)
	);
	$curveD = array(
		1 => intval(0),
		2 => intval(0),
		3 => intval(0),
		4 => intval(0),
		5 => intval(0),
		6 => intval(0),
		7 => intval(0),
		8 => intval(0),
		9 => intval(0)
	);
	$curveE = array(
		1 => intval(0),
		2 => intval(0),
		3 => intval(0),
		4 => intval(0),
		5 => intval(0),
		6 => intval(0),
		7 => intval(0),
		8 => intval(0),
		9 => intval(0)
	);

	$query = $db->prepare("SELECT * FROM decks WHERE id=:id");
	$arr = array(
			'id' => $_GET['d']
		);
	$x->arrayBinder($query, $arr);
	$query->execute();		
	$row = $query->fetch(PDO::FETCH_ASSOC);
	
	$json = $row['JSON'];
	$data = json_decode($json, TRUE);	
	for ($i = 0; $i < count($data['data']['scrolls']); $i++) {
	
		$query = $db->prepare("SELECT * FROM scrollsCard WHERE id=:id");
		$arr = array(
				'id' => $data['data']['scrolls'][$i]['id']
			);
		
		$x->arrayBinder($query, $arr);
		$query->execute();		
		$card = $query->fetch(PDO::FETCH_ASSOC);
	
		if ($data['msg'] == "success") {
		
		if (!empty($card['costorder'])) {
			$curveO[$card['costorder']] = $curveO[$card['costorder']] + $data['data']['scrolls'][$i]['c'];
		}
		if (!empty($card['costgrowth'])) {
			$curveG[$card['costgrowth']] = $curveG[$card['costgrowth']] + $data['data']['scrolls'][$i]['c'];
		}
		if (!empty($card['costdecay'])) {
			$curveD[$card['costdecay']] = $curveD[$card['costdecay']] + $data['data']['scrolls'][$i]['c'];
		}
		if (!empty($card['costenergy'])) {
			$curveE[$card['costenergy']] = $curveE[$card['costenergy']] + $data['data']['scrolls'][$i]['c'];
		}
		
		} 
	}
	
	$total = max($curveO) + max($curveG) + max($curveD) + max($curveE);
		

		
		
		
		
		
		$totalCostNumber = array(
		($curveO[1]+$curveG[1]+$curveD[1]+$curveE[1]),
		($curveO[2]+$curveG[2]+$curveD[2]+$curveE[2]),
		($curveO[3]+$curveG[3]+$curveD[3]+$curveE[3]),
		($curveO[4]+$curveG[4]+$curveD[4]+$curveE[4]),
		($curveO[5]+$curveG[5]+$curveD[5]+$curveE[5]),
		($curveO[6]+$curveG[6]+$curveD[6]+$curveE[6]),
		($curveO[7]+$curveG[7]+$curveD[7]+$curveE[7]),
		($curveO[8]+$curveG[8]+$curveD[8]+$curveE[8]),
		($curveO[9]+$curveG[9]+$curveD[9]+$curveE[9])
		);

	
	
	
	
		
	if ($handle = opendir($path)) {
		$files = scandir($path);
		$NUM_IMAGES = count($files) - 2;
 
		$width = $imagesPerRow * $iw;
		$height = ceil($NUM_IMAGES / $imagesPerRow) * $ih;
		$totalOffset = 88*5;
		$wallpaper = imagecreatetruecolor(678, $ih*count($listOfScrolls) + $totalOffset);
		
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
		
		
	$curveOffsetX = 10;
	$curveOffsetY = 70;
	
	$curveHeight = 300;	
	$barWidth = 40;	
	$allOffset = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
	
	imagecopyresampled($wallpaper, $curveBG, 0, 0, 0, 0, 678, $totalOffset, 678, 440);
	
	
	
	
	for ($i = 1; $i < 10; $i++) {
		imagettftext($wallpaper, $fontSize, 0, 20 +(60*$i), 50, $color, $font, $i);
	}
	
	for ($i = 1; $i < 10; $i++) {
		imagettftext($wallpaper, $fontSize, 0, 15 +(60*$i), 410, $color, $font, $totalCostNumber[$i-1]);
	}
	
	 for ($k = 1; $k < 10; $k++) {
			
			$gh = intval( ($curveG[$k] / $total * 100) );
			
			
			$barSpacing = 20 * $k;
			$xStart = $curveOffsetX + $barSpacing + ($barWidth*$k);
			$xEnd = $curveOffsetX + ($barWidth*$k) + $barSpacing + $barWidth;
			
			$cruveBaseoffset = ($gh * ($curveHeight / 100 ));
			
			$yStart = $curveOffsetY + $curveHeight - $cruveBaseoffset;
			$yEnd = $curveOffsetY + $curveHeight;
			
			
			
			if ($yStart / $yEnd != 1) {
				imagefilledrectangle($wallpaper, $xStart, $yStart, $xEnd, $yEnd, $orderGrowth);
			}
			$allOffset[$k-1] += ($yEnd - $yStart);		
	}
	for ($k = 1; $k < 10; $k++) {
				
				
				$gh = intval( ($curveO[$k] / $total * 100) );
				
				$barSpacing = 20 * $k;
				$xStart = $curveOffsetX + $barSpacing + ($barWidth*$k);
				$xEnd = $curveOffsetX + ($barWidth*$k) + $barSpacing + $barWidth;
				
				$cruveBaseoffset = ($gh * ($curveHeight / 100 ));
				
				$yStart = $curveOffsetY + $curveHeight - $cruveBaseoffset;
				$yEnd = $curveOffsetY + $curveHeight;
				
	//			print($xStart.", ".$xEnd." - ".$yStart.", ".$yEnd);
				
				
				if ($yStart / $yEnd != 1) {
					imagefilledrectangle($wallpaper, $xStart, $yStart - $allOffset[$k-1], $xEnd, $yEnd - $allOffset[$k-1], $orderOrder);
				}
				$allOffset[$k-1] += ($yEnd - $yStart);		
		}
	for ($k = 1; $k < 10; $k++) {
				$gh = intval( ($curveE[$k] / $total * 100) );
				
			
				$barSpacing = 20 * $k;
				$xStart = $curveOffsetX + $barSpacing + ($barWidth*$k);
				$xEnd = $curveOffsetX + ($barWidth*$k) + $barSpacing + $barWidth;
				
				$cruveBaseoffset = ($gh * ($curveHeight / 100 ));
				
				$yStart = $curveOffsetY + $curveHeight - $cruveBaseoffset;
				$yEnd = $curveOffsetY + $curveHeight;
				
	//			print($xStart.", ".$xEnd." - ".$yStart.", ".$yEnd);
				
				
				if ($yStart / $yEnd != 1) {
					imagefilledrectangle($wallpaper, $xStart, $yStart - $allOffset[$k-1], $xEnd, $yEnd - $allOffset[$k-1], $orderEnergy);
				}
				$allOffset[$k-1] += ($yEnd - $yStart);		
		}	
	for ($k = 1; $k < 10; $k++) {
				$gh = intval( ($curveD[$k] / $total * 100) );
				
			
				$barSpacing = 20 * $k;
				$xStart = $curveOffsetX + $barSpacing + ($barWidth*$k);
				$xEnd = $curveOffsetX + ($barWidth*$k) + $barSpacing + $barWidth;
				
				$cruveBaseoffset = ($gh * ($curveHeight / 100 ));
				
				$yStart = $curveOffsetY + $curveHeight - $cruveBaseoffset;
				$yEnd = $curveOffsetY + $curveHeight;
				
	//			print($xStart.", ".$xEnd." - ".$yStart.", ".$yEnd);
				
				
				if ($yStart / $yEnd != 1) {
					imagefilledrectangle($wallpaper, $xStart, $yStart - $allOffset[$k-1], $xEnd, $yEnd - $allOffset[$k-1], $orderDecay);
				}
				$allOffset[$k-1] += ($yEnd - $yStart);		
		}	
		
		
	for ($j = 0; $j < count($listOfScrolls); $j++) {
			$imgFile = $path . $listOfScrolls[$j][3].".png";
 
			$i = imagecreatefrompng($imgFile);
			
			list($fileId) = explode(".", $imgFile);
			
			$sw = imagesx($i);
			$sh = imagesy($i);
			
			$row = floor($c / $imagesPerRow);
			$col = $c % $imagesPerRow;
			
			$dx = $col * $iw;
			$dy = $row * $ih + $totalOffset;
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