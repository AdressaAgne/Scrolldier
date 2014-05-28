
 $(function() {
 
 var curvesG = [0, 0, 0, 0, 0, 0, 0, 0, 0];
 var curvesD = [0, 0, 0, 0, 0, 0, 0, 0, 0];
 var curvesE = [0, 0, 0, 0, 0, 0, 0, 0, 0];
 var curvesO = [0, 0, 0, 0, 0, 0, 0, 0, 0];
 	
 	
 	function updateCurve(cost, type, add) { 
 		if (add === true) {
 			if (type == "growth") {
 				curvesG[cost]++;	
 			}
 			if (type == "energy") {
 				curvesE[cost]++;	
 			}
 			if (type == "decay") {
 				curvesD[cost]++;	
 			}
 			if (type == "order") {
 				curvesO[cost]++;	
 			}
 		} else {
 			if (type == "growth") {
 				curvesG[cost]--;	
 			}
 			if (type == "energy") {
 				curvesE[cost]--;	
 			}
 			if (type == "decay") {
 				curvesD[cost]--;	
 			}
 			if (type == "order") {
 				curvesO[cost]--;	
 			}
 		}	
 		
 		setAllCurves(cost, type);
 		console.log(type + ", " + cost);
 	}
 	
 	
 	
 	function setCurve(cost, type) {
 		var curveGrowth = $("#curve-"+cost).find(".curve-growth");
 		var curveEnergy = $("#curve-"+cost).find(".curve-energy");
 		var curveDecay = $("#curve-"+cost).find(".curve-decay");
 		var curveOrder = $("#curve-"+cost).find(".curve-order");
 
 		
 		if (type == "growth") {
 			$(curveGrowth).css("height", calc(cost, type)+"%");
 		}
 		if (type == "energy") {
 			$(curveEnergy).css("height", calc(cost, type)+"%");
 		}
 		if (type == "decay") {
 			$(curveGrowth).css("height", calc(cost, type)+"%");
 		}
 		if (type == "order") {
 			$(curveOrder).css("height", calc(cost, type)+"%");
 		}
 	}
 	
 	function setOffset(cost) {
 		
 		var curveGrowth = parseInt($("#curve-"+cost).find(".curve-growth").css("height"));
 		var curveEnergy = parseInt($("#curve-"+cost).find(".curve-energy").css("height"));
 		var curveDecay = parseInt($("#curve-"+cost).find(".curve-decay").css("height"));
 		var curveOrder = parseInt($("#curve-"+cost).find(".curve-order").css("height"));
 		
 		$("#curve-"+cost).find("#offset").css("height", (100 - (curveGrowth + curveEnergy + curveDecay + curveOrder)) + "%");
 	}
 	
 	function setAllCurves(cost, type) {
 		for (var i = 0; i < 9; i++) {
 			setCurve(i, type);
 			setOffset(i);
 		}
 	}
 	
 	function calc(cost, type) {
 		var maxG = Math.max.apply(Math, curvesG);
 		var maxD = Math.max.apply(Math, curvesG);
 		var maxE = Math.max.apply(Math, curvesG);
 		var maxO = Math.max.apply(Math, curvesG);
 		
 		var maxCost = maxG + maxO + maxD + maxE;
 		
 		
 		if (type == "growth") {
 			return (curvesG[cost] / maxCost * 100);	
 		}
 		if (type == "energy") {
 			return (curvesE[cost] / maxCost * 100);	
 		}
 		if (type == "decay") {
 			return (curvesD[cost] / maxCost * 100);	
 		}
 		if (type == "order") {
 			return (curvesO[cost] / maxCost * 100);	
 		}
 	}
 	
 	
 	
 	
 	
 		
 			<div class="curvesBig">
 				<table>
 					<tr>
 						<td>0</td>
 						<td>0</td>
 						<td>0</td>
 						<td>0</td>
 						<td>0</td>
 						<td>0</td>
 						<td>0</td>
 						<td>0</td>
 						<td>0</td>
 					</tr>
 		<tr style="height: 100px;">
 				<td>
 					<div class="curveWrap" id="curve-1">
 						<div class="curve" id="offset" style="height: 100%;"></div>
 						<div class="curve curve-order" style="height: 0%;"></div>
 						<div class="curve curve-growth" style="height: 0%;"></div>
 						<div class="curve curve-decay" style="height: 0%;"></div>
 						<div class="curve curve-energy" style="height: 0%;"></div>
 					</div>
 				</td>
 				<td>
 					<div class="curveWrap" id="curve-2">
 						<div class="curve" id="offset" style="height: 100%;"></div>
 						<div class="curve curve-order" style="height: 0%;"></div>
 						<div class="curve curve-growth" style="height: 0%;"></div>
 						<div class="curve curve-decay" style="height: 0%;"></div>
 						<div class="curve curve-energy" style="height: 0%;"></div>
 					</div>
 				</td>
 				<td>
 					<div class="curveWrap" id="curve-3">
 						<div class="curve" id="offset" style="height: 100%;"></div>
 						<div class="curve curve-order" style="height: 0%;"></div>
 						<div class="curve curve-growth" style="height: 0%;"></div>
 						<div class="curve curve-decay" style="height: 0%;"></div>
 						<div class="curve curve-energy" style="height: 0%;"></div>
 					</div>
 				</td>
 				<td>
 					<div class="curveWrap" id="curve-4">
 						<div class="curve" id="offset" style="height: 100%;"></div>
 						<div class="curve curve-order" style="height: 0%;"></div>
 						<div class="curve curve-growth" style="height: 0%;"></div>
 						<div class="curve curve-decay" style="height: 0%;"></div>
 						<div class="curve curve-energy" style="height: 0%;"></div>
 					</div>
 				</td>
 				<td>
 					<div class="curveWrap" id="curve-5">
 						<div class="curve" id="offset" style="height: 100%;"></div>
 						<div class="curve curve-order" style="height: 0%;"></div>
 						<div class="curve curve-growth" style="height: 0%;"></div>
 						<div class="curve curve-decay" style="height: 0%;"></div>
 						<div class="curve curve-energy" style="height: 0%;"></div>
 					</div>
 				</td>
 				<td>
 					<div class="curveWrap" id="curve-6">
 						<div class="curve" id="offset" style="height: 100%;"></div>
 						<div class="curve curve-order" style="height: 0%;"></div>
 						<div class="curve curve-growth" style="height: 0%;"></div>
 						<div class="curve curve-decay" style="height: 0%;"></div>
 						<div class="curve curve-energy" style="height: 0%;"></div>
 					</div>
 				</td>
 				<td>
 					<div class="curveWrap" id="curve-7">
 						<div class="curve" id="offset" style="height: 100%;"></div>
 						<div class="curve curve-order" style="height: 0%;"></div>
 						<div class="curve curve-growth" style="height: 0%;"></div>
 						<div class="curve curve-decay" style="height: 0%;"></div>
 						<div class="curve curve-energy" style="height: 0%;"></div>
 					</div>
 				</td>
 				<td>
 					<div class="curveWrap" id="curve-8">
 						<div class="curve" id="offset" style="height: 100%;"></div>
 						<div class="curve curve-order" style="height: 0%;"></div>
 						<div class="curve curve-growth" style="height: 0%;"></div>
 						<div class="curve curve-decay" style="height: 0%;"></div>
 						<div class="curve curve-energy" style="height: 0%;"></div>
 					</div>
 				</td>
 				<td>
 					<div class="curveWrap" id="curve-9">
 						<div class="curve" id="offset" style="height: 100%;"></div>
 						<div class="curve curve-order" style="height: 0%;"></div>
 						<div class="curve curve-growth" style="height: 0%;"></div>
 						<div class="curve curve-decay" style="height: 0%;"></div>
 						<div class="curve curve-energy" style="height: 0%;"></div>
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
 
 
 });
 