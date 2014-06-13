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
	 "scroll/scrolls__scrollbase_decay_".$rarity."_result.png",
	 "scroll/scrolls__scrollbase_energy_".$rarity."_result.png",
	 "scroll/scrolls__scrollbase_growth_".$rarity."_result.png",
	 "scroll/scrolls__scrollbase_order_".$rarity."_result.png",
	 "scroll/scrolls__scrollbase_order_".$rarity."_result.png",
	 "scroll/scrolls__scrollbase_Chaos_".$rarity."_result.png"
	);
	
	return $scroll[$type];
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


function getRType($i = 0) {
	$scroll = array(
	 "scroll/256_decay_result.png",
	 "scroll/256_energy_result.png",
	 "scroll/256_growth_result.png",
	 "scroll/256_order_result.png",
	 "scroll/256_special_result.png",
	 "scroll/256_chaos_result.png"
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

$type = imagecreatefrompng(getRType($_POST['type']));


if ($_POST['tier'] != 0) {
	$tier = imagecreatefrompng(getTier($_POST['tier']));
}


$cardImage = imagecreatefrompng(getCardImage($_POST['cardImage']));

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
$fontsize = 25;


$cardImageW = 420;

//card Image
imagecopyresampled($bg, $cardImage, 82, 198, 0, 0, $cardImageW, $cardImageW * .75, 300, 225);

//scroll
imagecopyresampled($bg, $scroll, 0, $offset, 0, 0, 950*.59, 950, 512, 1024);

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
imagettftext($bg, $header_fontsize, 0, $x, 122, $header_color, $header_font, $text);


$scrollType = getScrollType($_POST['scrollType']);
if (empty($_POST['kin'])) {
	$_POST['kin'] = "";
} else {
	$scrollType.=": ";
}


$kin = $scrollType.$_POST['kin'];
$text_box = imagettfbbox($fontsize, 0 , $header_font, $kin);
$text_width = $text_box[2]-$text_box[0];
$x = ((950*.59)/2) - ($text_width/2);
imagettftext($bg, $fontsize, 0, $x+10, 160, $header_color, $header_font, $kin);



//statTable
if ($_POST['scrollType'] == 0 || $_POST['scrollType'] == 1) {
//1024x256
$statTable = imagecreatefrompng("scroll/scrolls__statsbar_result.png");


$statTableW = 420;
$statTableStart = 74;
imagecopyresampled($bg, $statTable, 73, $offset+460, 0, 0, $statTableW, $statTableW * .25, 1024, 256);

if (empty($_POST['ap'])) {
	$_POST['ap'] = -1;
}
if (empty($_POST['cd'])) {
	$_POST['cd'] = -1;
}
if (empty($_POST['hp'])) {
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


$textwidth = 270;
$text_a = explode(' ', $descText);
$text_new = '';
$text_new2 = '';
$lineheight = 0;
$lineheightIncrement = 28;

//print_r($text_a);

$wordSpcing = 0;

$spacing = 10;

$lastWord = 0;
$k = 0;

$isNewLine = false;


// Getting lore Text height
foreach($text_a as $word){

    $box = imagettfbbox($genral_fontsize, 0, $genral_font_i, $text_new.' '.$word);

    if($box[2] > $width - $margin*2){
        $text_new .= "\n".$word;
    } else {
        $text_new .= " ".$word;
    }
}

$boxHeight = abs($box[5] - $box[1]);


//if Cast Button then move lore text up
if (isset($_POST['Ability_btn'])) {
	$boxHeight += 80;
}
$lineWidth = 0;

//printing out each word
foreach($text_a as $word){

	//getting with of word
	$wordBox = imagettfbbox($genral_fontsize, 0, $genral_font_i, $word);
	
    if($wordBox[0] < -1) {
        $wordSpcing += abs($wordBox[2]) - abs($wordBox[0]) - 1;
    } else {
    	$wordSpcing += abs($wordBox[2] - $wordBox[0]);
    }
    
    //Width of line
    foreach($text_a as $word2){
    
        $boxLine = imagettfbbox($genral_fontsize, 0, $genral_font_i, $text_new2.' '.$word2);
    
        if($boxLine[2] > $textwidth){
            break;
        } else {
            $text_new2 .= " ".$word2;
        }
    }
	
	if($boxLine[0] < -1) {
	    $lineWidth = abs($boxLine[2] - $boxLine[0]) - 1;
	} else {
		$lineWidth = abs($boxLine[2] - $boxLine[0]);
	}
	
	//placeing
	$xWord = 95 + (($lastWord + ($spacing*$k)));
	$xWord -= (($textwidth/2) - ($lineWidth/2));
	
    imagettftext($bg, $genral_fontsize, 0, $xWord, intval(880+$lineheight) - $boxHeight, $header_color, $genral_font_i, $word);
    
    
    //resetting placeing when new line
    if ($wordSpcing >= $textwidth) {
		$isNewLine = true;
    	
		$wordSpcing = 0;
    	$lineheight += $lineheightIncrement;

		$k = 0;
		
    } else {
    	$k++;
        $isNewLine = false;
    	$text_new = ' '.$word;
    	    
    }
    
	$lastWord = $wordSpcing;
    
}


//////////// End Lore ////////////


if (isset($_POST['Ability_btn'])) {
	
	if (isset($_POST['Ability_btn_true']) && !empty($_POST['Ability_btn_true'])) {	
		$btn = imagecreatefrompng("scroll/scrolls__activability_result.png");	
		$btnW = 328;
		imagecopyresampled($bg, $btn, 120, 810, 0, 0, $btnW, $btnW*.29, 1024, 256);	
		
		$text_box = imagettfbbox($fontsize, 0 , $header_font, $_POST['Ability_btn_true']);
		
		$text_width = $text_box[2]-$text_box[0];
		
		$x = ((950*.59)/2) - ($text_width/2);
		
		imagettftext($bg, $fontsize, 0, $x, 865, $btn_color, $header_font, $_POST['Ability_btn_true']);
		
	}
	
}



//	$userDir = strtolower($_SESSION['username']);
//	$destDir = "user_files/".$userDir."/";
//	
//	
//	if (!is_dir($destDir)) {
//		mkdir($destDir, 0777, true);
//	}
//	
//	if (isset($_POST['overWrtie']) && !empty($_POST['overWrtie'])) {
//		$imageName = $_POST['overWrtie'];
//	} else {
//		$imageName = uniqid();
//	}
//	
//	$path = $destDir.$imageName.".png";
//	$parmaLink = $main."u/".$path;
//	
//	if (isset($_POST['overWrtie']) && !empty($_POST['overWrtie'])) {
//		//UPDATE scrolls SET html=:html, header=:header, byName=:byName, isHidden=:isHidden
//		$scroll_Query = $db->prepare("UPDATE fanScrolls SET ressource=:ressource, rarity=:rarity, type=:type, sub_type=:sub_type, title=:title, cost=:cost, tier=:tier, art=:art, ap=:ap, cd=:cd, hp=:hp, passive_1=:passive_1, passive_2=:passive_2, passive_3=:passive_3, description=:description, btn=:btn WHERE link=:link");
//		$scroll_Array = array(
//				'link' => $_POST['overWrtie'],
//				'ressource' => $_POST['type'],
//				'rarity' => $_POST['rarity'],
//				'type' => $_POST['scrollType'],
//				'sub_type' => $_POST['kin'],
//				'title' => $_POST['text'],
//				'cost' => $_POST['nr'],
//				'tier' => $_POST['tier'],
//				'art' => $_POST['cardImage'],
//				'ap' => $_POST['ap'],
//				'cd' => $_POST['cd'],
//				'hp' => $_POST['hp'],
//				'passive_1' => $_POST['p'],
//				'passive_2' => $_POST['pa'],
//				'passive_3' => $_POST['pas'],
//				'description' => $_POST['de'],
//				'btn' => $_POST['Ability_btn_true']
//				
//			); 
//		
//	} else {
//		$scroll_Query = $db->prepare("INSERT INTO fanScrolls 
//		(user, parma_link, link, ressource, rarity, type, sub_type, title, cost, tier, art, ap, cd, hp, passive_1, passive_2, passive_3, description, btn) VALUES (:ign, :pLink, :Link, :ressource, :rarity, :type, :sub_type, :title, :cost, :tier, :art, :ap, :cd, :hp, :passive_1, :passive_2, :passive_3, :description, :btn)");
//		
//		$scroll_Array = array(
//				'ign' => $_SESSION['username'],
//				'pLink' => $parmaLink,
//				'Link' => $imageName,
//				'ressource' => $_POST['type'],
//				'rarity' => $_POST['rarity'],
//				'type' => $_POST['scrollType'],
//				'sub_type' => $_POST['kin'],
//				'title' => $_POST['text'],
//				'cost' => $_POST['nr'],
//				'tier' => $_POST['tier'],
//				'art' => $_POST['cardImage'],
//				'ap' => $_POST['ap'],
//				'cd' => $_POST['cd'],
//				'hp' => $_POST['hp'],
//				'passive_1' => $_POST['p'],
//				'passive_2' => $_POST['pa'],
//				'passive_3' => $_POST['pas'],
//				'description' => $_POST['de'],
//				'btn' => $_POST['Ability_btn_true']
//				
//			); 
//	}
//
//	
//	
//	   $xClass->arrayBinder($scroll_Query, $scroll_Array);
//	
//		if ($scroll_Query->execute()) {
//			if (file_exists($path)) {
//				unlink($path);
//			}
//			imagepng($bg, $path);
//			
//			imagedestroy($bg);
//			header("location: ".$main."fanart/".$imageName);			
//		}
	
	imagepng($bg);

?>