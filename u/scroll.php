<?php
include('../admin/mysql/connect.php');
include('../admin/mysql/function.php');
$xClass = new xClass();
//header ('Content-Type: image/png');
session_start();


$width = 512;
$height = 1088;




function getBack($type, $rarity = 0) {
	$scroll = array(
	 "scroll/scrolls__scrollbase_decay_".$rarity."_result.png",
	 "scroll/scrolls__scrollbase_energy_".$rarity."_result.png",
	 "scroll/scrolls__scrollbase_growth_".$rarity."_result.png",
	 "scroll/scrolls__scrollbase_order_".$rarity."_result.png",
	 "scroll/scrolls__scrollbase_Wild_".$rarity."_result.png",
	 "scroll/scrolls__scrollbase_Chaos_".$rarity."_result.png",
	  "scroll/scrolls__scrollbase_neutral_".$rarity.".png",
	);
	
	return $scroll[$type];
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

function getCardImage($i) {
	return "../resources/cardImages/".$i.".png";
}

function getNumber($i = 0) {
	if ($i == -1) {
		$number = "scroll/scroll_numbers____result.png";
	} else {
		$number = "scroll/scroll_numbers__".$i."_result.png";
	}

	return $number;
}

function getCostNumber($i = 0) {
	if ($i < 0) {
		$number = "scroll/yellow_0_result.png";
	}
	elseif ($i > 9) {
		$number = "scroll/yellow_9_result.png";
	} else {
		$number = "scroll/yellow_".$i."_result.png";
	}

	return $number;
}

function getOverlay($i) {
	return "scroll/scrolls__scrollbase_colorizarion_layer_".$i.".png";
}

function getRType($i = 0) {
	$scroll = array(
	 "scroll/256_decay_result.png",
	 "scroll/256_energy_result.png",
	 "scroll/256_growth_result.png",
	 "scroll/256_order_result.png",
	 "scroll/256_special_result.png",
	 "scroll/256_chaos_result.png",
	 "scroll/256_custome_result.png"
	);
	return $scroll[$i];
}

function getTier($i = 0) {
	$scroll = array(
	 "",
	 "scroll/crafting_3_3_result.png",
	 "scroll/crafting_3_2_result.png"
	);
	return $scroll[$i];
}

function getScrollType($i = 0) {
	$scroll = array(
	 "CREATURE",
	 "STRUCTURE",
	 "SPELL",
	 "ENCHANTMENT"
	);
	return $scroll[$i];
}

$bg = imagecreatefrompng("../resources/bg.png");


$scroll = imagecreatefrompng(getBack($_POST['type'], $_POST['rarity']));

$overlay = imagecreatefrompng(getOverlay($_POST['rarity']));


$type = imagecreatefrompng(getRType($_POST['type']));


if ($_POST['tier'] != 0) {
	$tier = imagecreatefrompng(getTier($_POST['tier']));
}


$cardImage = imagecreatefrompng($_POST['cardImage']);

$number = imagecreatefrompng(getCostNumber($_POST['nr']));

$plate = imagecreatefrompng("scroll/scrolls__resource_cost_result.png");




imagealphablending($bg, true);
imagesavealpha($bg, true);

$offset = 10;
$plateWidth = 170;


//text
$header_font = "font.ttf";

$header_color = imagecolorallocate($bg, 61, 43, 33);
$text_color = imagecolorallocate($bg, 248, 248, 248);
$btn_color = imagecolorallocate($bg, 255, 255, 255);

$header_fontsize = 40;
$genral_fontsize = 25;


$cardImageW = 420;

//card Image
imagecopyresampled($bg, $cardImage, 82, 198, 0, 0, $cardImageW, $cardImageW * .75, 300, 225);

//scroll

if ($_POST['type'] >= 4) {
	imagecopyresampled($bg, $scroll, 0, $offset, 0, 0, 950*.59, 950, 633, 1024);
} else {
	imagecopyresampled($bg, $scroll, 0, $offset, 0, 0, 950*.59, 950, 512, 1024);
}

if ($_POST['type'] == 6) {

$r = $_POST['colorR'];
$g = $_POST['colorG'];
$b = $_POST['colorB'];



$rgb = array($r,$g,$b);


$rgb = array(255-$rgb[0],255-$rgb[1],255-$rgb[2]);
imagealphablending($type, false );
imagesavealpha( $type, true );

imagealphablending($overlay, false );
imagesavealpha( $overlay, true );

imagefilter($overlay, IMG_FILTER_NEGATE); 
imagefilter($overlay, IMG_FILTER_COLORIZE, $rgb[0], $rgb[1], $rgb[2]); 
imagefilter($overlay, IMG_FILTER_NEGATE); 

imagefilter($type, IMG_FILTER_NEGATE); 
imagefilter($type, IMG_FILTER_COLORIZE, $rgb[0], $rgb[1], $rgb[2]); 
imagefilter($type, IMG_FILTER_NEGATE); 

//set faction overlay
imagecopyresampled($bg, $overlay, 0, $offset, 0, 0, 950*.59, 950, 633, 1024);

}
//tier
if ($_POST['tier'] != 0) {
	imagecopyresampled($bg, $tier, 0, $offset, 0, 0, 950*.59, 950, 633, 1024);
}
	

//cost type plate
imagecopyresampled($bg, $plate, 200, 0, 0, 0, $plateWidth, $plateWidth/2, 512, 256);

//ressource



if ($_POST['type'] == 5) {
	imagecopyresampled($bg, $type, 225, 11, 0, 0, 60, 56, 141, 124);
} else {
	imagecopyresampled($bg, $type, 225, 7, 0, 0, 64, 64, 256, 256);
}
//cost
imagecopyresampled($bg, $number, 290, $offset+5, 0, 0, imageSX($number)*.8, imageSY($number)*.8, imageSX($number), imageSY($number));

//text
if (empty($_POST['text'])) {
	$_POST['text'] = "";
}

$text = $_POST['text'];

$text_box = imagettfbbox($header_fontsize, 0 , $header_font, $text);
$text_width = $text_box[2]-$text_box[0];
$x = ((950*.59)/2) - ($text_width/2);
imagettftext($bg, $header_fontsize, 0, $x+5, 122, $header_color, $header_font, $text);


$scrollType = getScrollType($_POST['scrollType']);
if (empty($_POST['kin'])) {
	$_POST['kin'] = "";
} else {
	$scrollType.=": ";
}


$kin = $scrollType.$_POST['kin'];
$text_box = imagettfbbox($genral_fontsize, 0 , $header_font, $kin);
$text_width = $text_box[2]-$text_box[0];
$x = ((950*.59)/2) - ($text_width/2);
imagettftext($bg, $genral_fontsize, 0, $x+10, 160, $header_color, $header_font, $kin);



//statTable
if ($_POST['scrollType'] == 0 || $_POST['scrollType'] == 1) {
//1024x256
$statTable = imagecreatefrompng("scroll/scrolls__statsbar_result.png");


$statTableW = 420;
$statTableStart = 74;
imagecopyresampled($bg, $statTable, 73, $offset+460, 0, 0, $statTableW, $statTableW * .25, 1024, 256);

if (empty($_POST['ap']) && $_POST['ap'] != 0) {
	$_POST['ap'] = -1;
}
if (empty($_POST['cd']) && $_POST['cd'] != 0) {
	$_POST['cd'] = -1;
}
if (empty($_POST['hp']) && $_POST['hp'] != 0) {
	$_POST['hp'] = -1;
}

$ap = imagecreatefrompng(getNumber($_POST['ap']));
imagecopyresampled($bg, $ap, $statTableStart+85, 500, 0, 0, 38, 38, 128, 128);	
	
$hp = imagecreatefrompng(getNumber($_POST['cd']));
imagecopyresampled($bg, $hp, $statTableStart+210, 500, 0, 0, 38, 38, 128, 128);	

$cd = imagecreatefrompng(getNumber($_POST['hp']));
imagecopyresampled($bg, $cd, $statTableStart+330, 500, 0, 0, 38, 38, 128, 128);	
}


$genral_font = "honeymeadbold.ttf";
$genral_font_i = "honeymeadbolditalic.ttf";

$genral_fontsize = 24;

$breadTextOffset = 0;
$breadTextOffsetExpand = $genral_fontsize;
$wrapBreak = 34;
$passiveWrapBreak = $wrapBreak - 5;

function moveTextDown() {
	$breadTextOffset += $breadTextOffsetExpand;
}

if (!empty($_POST['p'])) {
	$p = "* ".$_POST['p'];
	imagettftext($bg, $genral_fontsize, 0, 100, intval(590+$breadTextOffset), $header_color, $genral_font_i, wordwrap($p, $passiveWrapBreak, "\n"));
	
	if (strlen($p) > $passiveWrapBreak) {
		$breadTextOffset += $breadTextOffsetExpand;
	}
	$breadTextOffset += $breadTextOffsetExpand;
}
if (!empty($_POST['pa'])) {
	$pa = "* ".$_POST['pa'];
	imagettftext($bg, $genral_fontsize, 0, 100, intval(590+$breadTextOffset), $header_color, $genral_font_i, wordwrap($pa, $passiveWrapBreak, "\n"));
	
	if (strlen($pa) > $passiveWrapBreak) {
		$breadTextOffset += $breadTextOffsetExpand;
	}
	$breadTextOffset += $breadTextOffsetExpand;
	
}
if (!empty($_POST['pas'])) {
	$pas = "* ".$_POST['pas'];
	imagettftext($bg, $genral_fontsize, 0, 100, intval(590+$breadTextOffset), $header_color, $genral_font_i, wordwrap($pas, $passiveWrapBreak, "\n"));

	if (strlen($pas) > $passiveWrapBreak) {
		$breadTextOffset += $breadTextOffsetExpand;
	}
	$breadTextOffset += $breadTextOffsetExpand;
}

//////////// Start Desc ////////////

$margin = 5;
$descText = $_POST['de'];

$descText = preg_replace('/^\s+|\n|\r|\s+$/m', ' ',$descText);
$descText = preg_replace('/\s+/', ' ',$descText);


//explode text by words
$textwidth = 270;
$text_a = explode(' ', $descText);
$text_new = '';
$lineheight = 0;
$lineheightIncrement = 28;


//$bgColor = imagecolorallocate($bg, 18, 19, 20);
//imagefilledrectangle($bg, 100, 800,100+$textwidth, 700, $bgColor);
//print_r($text_a);

$wordSpcing = 0;

$spacing = 10;

$lastWord = 0;
$k = 0;

$isNewLine = false;
foreach($text_a as $word){
	$wordBox = imagettfbbox($genral_fontsize, 0, $genral_font, $word);
    
	
    if($wordBox[0] < -1) {
        $wordSpcing += abs($wordBox[2]) - abs($wordBox[0]) - 1;
    } else {
    	$wordSpcing += abs($wordBox[2] - $wordBox[0]);
    }

	
    imagettftext($bg, $genral_fontsize, 0, 95+($lastWord + ($spacing*$k)), intval(600+$breadTextOffset+$lineheight), $header_color, $genral_font, $word);
    
    if ($wordSpcing >= $textwidth) {
		$isNewLine = true;
    		
    		
		$wordSpcing = 0;
    	$lineheight += $lineheightIncrement;

		$k = 0;
    } else {
    	$k++;
        $isNewLine = false;
    		
    	    
    }
    
	$lastWord = $wordSpcing;
    
}
////////////  End Desc  ////////////
//////////// Start Lore ////////////
$descText = $_POST['lore'];



$totalWidth = 350;
$words = explode(' ', $_POST['lore']);
 
 $words = preg_replace('/^\s+|\n|\r|\s+$/m', ' ',$words);
 $words = preg_replace('/\s+/', ' ',$words);
 
$lines = array();




 

 
// just so i can remember / see its structure :)
$line = array('width' 	=> 0,
              'height'	=> 0,
              'text'	=> "");
                         
$numWords = 0;
 
// create array of lines
foreach($words as $word){
        $word .= ' ';
        $bb = imagettfbbox($genral_fontsize, 0, $genral_font_i, $word);
       
        if ($line['width'] + $bb[2] > $totalWidth) {
                array_push($lines, $line); // push back a copy of line into our array
               
                $line['width'] = 0;
                $line['height'] = 0;
                $line['text'] = "";
        }
       
        $line['width'] += $bb[2]; // x2 should equal width, since x1 == 0
        if ($line['height'] < $bb[3])
                $line['height'] = $bb[3]; // we should go with the highest height in the line
               
        $line['text'] .= $word; // trailing space is fine
}
 
array_push($lines, $line); // push back a copy of line into our array
 
 
 $boxHeight = 0;
 for ($i = 0; $i < count($lines); $i++) {
 	$boxHeight += 22;
 }
 if (isset($_POST['Ability_btn'])) {
 	$boxHeight += 80;
 }
 
 $startY = 870 - $boxHeight;
 
 
// render the lines
foreach($lines as $key => $line){
        $x = $totalWidth/2 - $line['width']/2;
        $y = $startY + (($key+1) * 15) * 1.5;
        imagettftext($bg, $genral_fontsize, 0, 100+$x, $y, $header_color, $genral_font_i, $line['text']);
}
 
//////////// End Lore ////////////


if (isset($_POST['Ability_btn'])) {
	
	if (isset($_POST['Ability_btn_true']) && !empty($_POST['Ability_btn_true'])) {	
		$btn = imagecreatefrompng("scroll/scrolls__activability_result.png");	
		$btnW = 328;
		imagecopyresampled($bg, $btn, 120, 810, 0, 0, $btnW, $btnW*.29, 1024, 256);	
		
		$text_box = imagettfbbox($genral_fontsize, 0 , $header_font, $_POST['Ability_btn_true']);
		
		$text_width = $text_box[2]-$text_box[0];
		
		$x = ((950*.59)/2) - ($text_width/2);
		
		imagettftext($bg, $genral_fontsize, 0, $x, 865, $btn_color, $header_font, $_POST['Ability_btn_true']);
		
	}
	
}



	$userDir = strtolower($_SESSION['username']);
	$destDir = "user_files/".$userDir."/";
	
	
	if (!is_dir($destDir)) {
		mkdir($destDir, 0777, true);
	}
	
	if (isset($_POST['overWrtie']) && !empty($_POST['overWrtie'])) {
		$imageName = $_POST['overWrtie'];
	} else {
		$imageName = uniqid();
	}
	
	$path = $destDir.$imageName.".png";
	$parmaLink = $main."u/".$path;
	
	if (isset($_POST['overWrtie']) && !empty($_POST['overWrtie'])) {

		$scroll_Query = $db->prepare("UPDATE fanScrolls SET ressource=:ressource, rarity=:rarity, type=:type, sub_type=:sub_type, title=:title, cost=:cost, tier=:tier, art=:art, ap=:ap, cd=:cd, hp=:hp, passive_1=:passive_1, passive_2=:passive_2, passive_3=:passive_3, description=:description, btn=:btn, lore=:lore WHERE link=:link");
		$scroll_Array = array(
				'link' => $_POST['overWrtie'],
				'ressource' => $_POST['type'],
				'rarity' => $_POST['rarity'],
				'type' => $_POST['scrollType'],
				'sub_type' => $_POST['kin'],
				'title' => $_POST['text'],
				'cost' => $_POST['nr'],
				'tier' => $_POST['tier'],
				'art' => $_POST['cardImage'],
				'ap' => $_POST['ap'],
				'cd' => $_POST['cd'],
				'hp' => $_POST['hp'],
				'passive_1' => $_POST['p'],
				'passive_2' => $_POST['pa'],
				'passive_3' => $_POST['pas'],
				'description' => $_POST['de'],
				'btn' => $_POST['Ability_btn_true'],
				'lore' => $_POST['lore']
				
			); 
		
	} else {
		$scroll_Query = $db->prepare("INSERT INTO fanScrolls 
		(user, parma_link, link, ressource, rarity, type, sub_type, title, cost, tier, art, ap, cd, hp, passive_1, passive_2, passive_3, description, btn, lore) VALUES (:ign, :pLink, :Link, :ressource, :rarity, :type, :sub_type, :title, :cost, :tier, :art, :ap, :cd, :hp, :passive_1, :passive_2, :passive_3, :description, :btn, :lore)");
		
		$scroll_Array = array(
				'ign' => $_SESSION['username'],
				'pLink' => $parmaLink,
				'Link' => $imageName,
				'ressource' => $_POST['type'],
				'rarity' => $_POST['rarity'],
				'type' => $_POST['scrollType'],
				'sub_type' => $_POST['kin'],
				'title' => $_POST['text'],
				'cost' => $_POST['nr'],
				'tier' => $_POST['tier'],
				'art' => $_POST['cardImage'],
				'ap' => $_POST['ap'],
				'cd' => $_POST['cd'],
				'hp' => $_POST['hp'],
				'passive_1' => $_POST['p'],
				'passive_2' => $_POST['pa'],
				'passive_3' => $_POST['pas'],
				'description' => $_POST['de'],
				'btn' => $_POST['Ability_btn_true'],
				'lore' => $_POST['lore']
			); 
	}

	
	
	   $xClass->arrayBinder($scroll_Query, $scroll_Array);
	
		if ($scroll_Query->execute()) {
			if (file_exists($path)) {
				unlink($path);
			}
			imagepng($bg, $path);
			
			imagedestroy($bg);
			header("location: ".$main."fanart/".$imageName);			
		}
	
//	imagepng($bg);

?>