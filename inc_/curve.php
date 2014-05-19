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

function addBigColoredCurve($deckID) {
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
	
	$start = '<div class="mR deckScrollList clearfix">					
				<div class="curvesBig">
					<table>
						<tr>
							<td>'.($curveO[1]+$curveG[1]+$curveD[1]+$curveE[1]).'</td>
							<td>'.($curveO[2]+$curveG[2]+$curveD[2]+$curveE[2]).'</td>
							<td>'.($curveO[3]+$curveG[3]+$curveD[3]+$curveE[3]).'</td>
							<td>'.($curveO[4]+$curveG[4]+$curveD[4]+$curveE[4]).'</td>
							<td>'.($curveO[5]+$curveG[5]+$curveD[5]+$curveE[5]).'</td>
							<td>'.($curveO[6]+$curveG[6]+$curveD[6]+$curveE[6]).'</td>
							<td>'.($curveO[7]+$curveG[7]+$curveD[7]+$curveE[7]).'</td>
							<td>'.($curveO[8]+$curveG[8]+$curveD[8]+$curveE[8]).'</td>
							<td>'.($curveO[9]+$curveG[9]+$curveD[9]+$curveE[9]).'</td>
						</tr>
					<tr style="height: 100px;">';
	$middle = "";				
	 for ($k = 1; $k < 10; $k++) {
	 	$offset = intval(
	 			100 - (
	 			($curveO[$k] / $total * 100) +
	 			($curveG[$k] / $total * 100) +
	 			($curveD[$k] / $total * 100) +
	 			($curveE[$k] / $total * 100)
	 			)
	 			);
		$middle .= '<td>
						<div class="curveWrap">
							<div class="curve" style="height: '.$offset.'%;"></div>
							<div class="curve curve-order" style="height: '.intval( ($curveO[$k] / $total * 100) ).'%;"></div>
							<div class="curve curve-growth" style="height: '.intval( ($curveG[$k] / $total * 100) ).'%;"></div>
							<div class="curve curve-decay" style="height: '.intval( ($curveD[$k] / $total * 100) ).'%;"></div>
							<div class="curve curve-energy" style="height: '.intval( ($curveE[$k] / $total * 100) ).'%;"></div>
						</div>
					</td>';
	}
	
	$end = '</tr>
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
	
	return $start.$middle.$end;
			
	} 
  ?>