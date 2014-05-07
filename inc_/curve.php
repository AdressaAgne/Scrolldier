<?php 

function addCurve($deckID) {
	$curve = array(
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
	
	include('admin/mysql/connect.php');
	include_once('admin/mysql/function.php');
	$x = new xClass();
	$query = $db->prepare("SELECT * FROM decks WHERE id=:id");
	$arr = array(
			'id' => $deckID
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
			$curve[$card['costorder']] = $curve[$card['costorder']] + $data['data']['scrolls'][$i]['c'];
		}
		if (!empty($card['costgrowth'])) {
			$curve[$card['costgrowth']] = $curve[$card['costgrowth']] + $data['data']['scrolls'][$i]['c'];
		}
		if (!empty($card['costdecay'])) {
			$curve[$card['costdecay']] = $curve[$card['costdecay']] + $data['data']['scrolls'][$i]['c'];
		}
		if (!empty($card['costenergy'])) {
			$curve[$card['costenergy']] = $curve[$card['costenergy']] + $data['data']['scrolls'][$i]['c'];
		}
		
		} 
	}

	
	return '<div class="curves">
				<div class="curve" style="height: '.intval( ($curve[1] / max($curve) * 100) ).'%;"></div>
				<div class="curve" style="height: '.intval( ($curve[2] / max($curve) * 100) ).'%;"></div>
				<div class="curve" style="height: '.intval( ($curve[3] / max($curve) * 100) ).'%;"></div>
				<div class="curve" style="height: '.intval( ($curve[4] / max($curve) * 100) ).'%;"></div>
				<div class="curve" style="height: '.intval( ($curve[5] / max($curve) * 100) ).'%;"></div>
				<div class="curve" style="height: '.intval( ($curve[6] / max($curve) * 100) ).'%;"></div>
				<div class="curve" style="height: '.intval( ($curve[7] / max($curve) * 100) ).'%;"></div>
				<div class="curve" style="height: '.intval( ($curve[8] / max($curve) * 100) ).'%;"></div>
				<div class="curve" style="height: '.intval( ($curve[9] / max($curve) * 100) ).'%;"></div>
			</div>';
	}


 
 function addBigCurve($deckID) {
 	$curve = array(
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
 	
 	include('admin/mysql/connect.php');
 	include_once('admin/mysql/function.php');
 	$x = new xClass();
 	$query = $db->prepare("SELECT * FROM decks WHERE id=:id");
 	$arr = array(
 			'id' => $deckID
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
 			$curve[$card['costorder']] = $curve[$card['costorder']] + $data['data']['scrolls'][$i]['c'];
 		}
 		if (!empty($card['costgrowth'])) {
 			$curve[$card['costgrowth']] = $curve[$card['costgrowth']] + $data['data']['scrolls'][$i]['c'];
 		}
 		if (!empty($card['costdecay'])) {
 			$curve[$card['costdecay']] = $curve[$card['costdecay']] + $data['data']['scrolls'][$i]['c'];
 		}
 		if (!empty($card['costenergy'])) {
 			$curve[$card['costenergy']] = $curve[$card['costenergy']] + $data['data']['scrolls'][$i]['c'];
 		}
 		
 		} 
 	}
 
 	
 	return '<div class="mR deckScrollList clearfix">					
 				<div class="curvesBig">
 					<table>
 						<tr>
 							<td>'.$curve[1].'</td>
 							<td>'.$curve[2].'</td>
 							<td>'.$curve[3].'</td>
 							<td>'.$curve[4].'</td>
 							<td>'.$curve[5].'</td>
 							<td>'.$curve[6].'</td>
 							<td>'.$curve[7].'</td>
 							<td>'.$curve[8].'</td>
 							<td>'.$curve[9].'</td>
 						</tr>
 						<tr style="height: 100px;">
 							<td>
 								<div class="curveWrap">
 									<div class="curve" style="height: '.intval( ($curve[1] / max($curve) * 100) ).'%;"></div>
 								</div>
 							</td>
 							<td>
 								<div class="curveWrap">
 									<div class="curve" style="height: '.intval( ($curve[2] / max($curve) * 100) ).'%;"></div>
 								</div>
 							</td>
 							<td>
 								<div class="curveWrap">
 									<div class="curve" style="height: '.intval( ($curve[3] / max($curve) * 100) ).'%;"></div>
 								</div>
 							</td>
 							<td>
 								<div class="curveWrap">
 									<div class="curve" style="height: '.intval( ($curve[4] / max($curve) * 100) ).'%;"></div>
 								</div>
 							</td>
 							<td>
 								<div class="curveWrap">
 									<div class="curve" style="height: '.intval( ($curve[5] / max($curve) * 100) ).'%;"></div>
 								</div>
 							</td>
 							<td>
 								<div class="curveWrap">
 									<div class="curve" style="height: '.intval( ($curve[6] / max($curve) * 100) ).'%;"></div>
 								</div>
 							</td>
 							<td>
 								<div class="curveWrap">
 									<div class="curve" style="height: '.intval( ($curve[7] / max($curve) * 100) ).'%;"></div>
 								</div>
 							</td>
 							<td>
 								<div class="curveWrap">
 									<div class="curve" style="height: '.intval( ($curve[8] / max($curve) * 100) ).'%;"></div>
 								</div>
 							</td>
 							<td>
 								<div class="curveWrap">
 									<div class="curve" style="height: '.intval( ($curve[9] / max($curve) * 100) ).'%;"></div>
 								</div>
 							</td>
 							
 						</tr>
 						<tr style="height: 20px;">
 							<td>1</td>
 							<td>2</td>
 							<td>3</td>
 							<td>4</td>
 							<td>5</td>
 							<td>6</td>
 							<td>7</td>
 							<td>8</td>
 							<td>9</td>
 						</tr>
 					</table>
 					
 				</div>
 			</div>';
 			
 	}
 
  ?>