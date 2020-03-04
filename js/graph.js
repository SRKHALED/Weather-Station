window.onload = function () { 
	var chart = new CanvasJS.Chart("chartContainer", {            
		axisY: {
			includeZero: false,
			suffix: " °সে",
			maximum: 40,
			gridThickness: 0
		},
		toolTip:{
			shared: true,
			content: " <strong>তাপমাত্রা: </strong> </br> সর্বনিন্ম: {y[0]} °সে, সর্বোচ্চ: {y[1]} °সে"
		},
		data: [{
			type: "rangeSplineArea",
			fillOpacity: 0.1,
			color: "blue",
			indexLabelFormatter: formatter,
			dataPoints: [
				{ label: "সোমবার", y: [23, 32]},
				{ label: "মঙ্গলবার", y: [25, 37]},
				{ label: "বুধবার", y: [20, 27]},
				{ label: "বূহ:বার", y: [24, 30]},
				{ label: "শুক্রবার", y: [24, 26] },
				{ label: "শনিবার", y: [22, 28] },
				{ label: "রবিবার", y: [26, 32]}
			]
		}]
	});
	chart.render();

	 
	function formatter(e) { 
		if(e.index === 0 && e.dataPoint.x === 0) {
			return " সর্বনিন্ম " + e.dataPoint.y[e.index] + "°";
		} else if(e.index == 1 && e.dataPoint.x === 0) {
			return " সর্বোচ্চ " + e.dataPoint.y[e.index] + "°";
		} else{
			return e.dataPoint.y[e.index] + "°";
		}
	} 		 
} 