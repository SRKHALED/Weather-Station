<!DOCTYPE html>
<html>
<head>
	<title>weather Station</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style.css">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="js/date_time.js"></script>
	<script src="js/jquery.min.js"></script>
  	<script src="js/bootstrap.min.js"></script>
	<script src="js/canvasjs.min.js"></script>
</head>
<body>
	<header>
      <br>
      <nav class='navbar navbar-expand-lg navbar-light'>
        <br>
          <a href = 'index.php'><h1 style='text-align : left; color : white;'><b>আবহাওয়া বার্তা</b></h1></a>
          <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation' style='background-color: white;'>
        <span class='navbar-toggler-icon'></span>
          </button>
          <br>
          <div class='collapse navbar-collapse' id='navbarSupportedContent'>
            <ul class='navbar-nav ml-auto'>
              <li class='nav-item'>
                <a class='nav-link' href='index.php'>
                  <button class='btn btn-info' style='width: 125px;'>বর্তমান অবস্তা</button>
                </a>
              </li>
              <li class='nav-item'>
                <a class='nav-link' href='update.php'>
                  <button class='btn btn-info' style='width: 125px;'>পূর্বাভাস</button>
                </a>
              </li>
              <li class='nav-item'>
                <a class='nav-link' href='privious.php'>
                  <button class='btn btn-secondary active' style='width: 125px;'>পূর্বের অবস্তা</button>
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
	<?php 
		include 'E2B.php';
		include 'DBconnection.php';
		$day = date('w');
	    $j=0;
	    $bday=['রবিবার','সোমবার','মঙ্গলবার','বুধবার','বৃহস্পতিবার','শুক্রবার','শনিবার'];
	    for($i=$day; $i<7; $i++){
	    	$fd[$j]=$bday[$i];
	    	$j++;
	    }
	    for($i=0; $i<$day; $i++){
	    	$fd[$j]=$bday[$i];
	    	$j++;
	    }
	 ?>
	<br>
	<div class="container"> 
	    <br>
	    <div id="chartContainer" style="height: 375px; max-width: 100%; margin: 0px auto;"></div>
	    <br>
	    <!-- <div class="row"> -->
	    	<!-- <div class="col-sm-6"><div id="chartContainer1" style="height: 375px; max-width: 100%; margin: 0px auto;"></div></div> -->
	    	<!-- <div class="col-sm-6"><div id="chartContainer2" style="height: 375px; max-width: 100%; margin: 0px auto;"></div></div> -->
	    <!-- </div> -->
	    <div id="chartContainer1" style="height: 375px; max-width: 100%; margin: 0px auto;"></div>
	    <br>
	    <div class="card">
	    	<table class="table table-striped">
	    		<thead class="thead-dark">
		    		<tr>
		    			<th scope="col">#</th>
		    			<th scope="col">তারিখ</th>
		    			<th scope="col">গড় তাপমাত্রা</th>
		    			<th scope="col">সর্বোচ্চ তাপমাত্রা</th>
		    			<th scope="col">সর্বনিন্ম তাপমাত্রা</th>
		    			<th scope="col">আদ্রতা</th>
		    			<th scope="col">বায়ুচাপ</th>
		    			<th scope="col">বাতাস এর গতি </th>
		    			<th scope="col">বৃষ্টিপাত  </th>
		    		</tr>
		    	</thead>
		    	<tbody>
		    		<?php
		    			$i=0;
		    			$sql="SELECT * FROM `final_data` ORDER BY `D_id` DESC LIMIT 6";
					    $result = $conn->query($sql);
					    if ($result->num_rows > 0) {
					    	while($row = $result->fetch_assoc()){
					    		$day = $row["day"];
					        	$avg_temp = $row["avg_tmp"];
					        	$max_temp[$i] = $row["max_temp"];
					        	$min_temp[$i] = $row["min_temp"];
					        	$humidity[$i] = $row["avg_humi"];
					        	$prsser = $row["avg_press"];
					        	$ws = $row["avg_ws"];
					        	$rain[$i] = $row["rain"];
					        	echo "<tr>
						    			<th scope='row'>".E2B::en2bn($i+1)."</th>
						    			<td>".E2B::en2bn($day)."</td>
						    			<td>".E2B::en2bn($avg_temp)."<sup>o</sup><sub>সে</sub></td>
						    			<td>".E2B::en2bn($max_temp[$i])."<sup>o</sup><sub>সে</sub></td>
						    			<td>".E2B::en2bn($min_temp[$i])."<sup>o</sup><sub>সে</sub></td>
						    			<td>".E2B::en2bn($humidity[$i])."%</td> 
						    			<td>".E2B::en2bn($prsser)."</td>
						    			<td>".E2B::en2bn($ws)."কি.মি./ঘণ্টা</td>
						    			<td>".E2B::en2bn($rain[$i])."</td>
						    		</tr>"; 
						    		$i++;
					    	}
					    }
		    		?>
		    	</tbody>
	    	</table>
	    </div>
	</div>
	<hr>
	<footer><br></footer>
	<script> 
	var chart = new CanvasJS.Chart("chartContainer", {
		title:{
		text: " তাপমাত্রা গ্রাফ "
		},
		backgroundColor : "white",            
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
				{ label: "<?php echo $fd[1]; ?>", y: [<?php echo $min_temp[5];?>, <?php echo $max_temp[5];?>]},
				{ label: "<?php echo $fd[2]; ?>", y: [<?php echo $min_temp[4];?>, <?php echo $max_temp[4];?>]},
				{ label: "<?php echo $fd[3]; ?>", y: [<?php echo $min_temp[3];?>, <?php echo $max_temp[3];?>]},
				{ label: "<?php echo $fd[4]; ?>", y: [<?php echo $min_temp[2];?>, <?php echo $max_temp[2];?>]},
				{ label: "<?php echo $fd[5]; ?>", y: [<?php echo $min_temp[1];?>, <?php echo $max_temp[1];?>] },
				{ label: "<?php echo $fd[6]; ?>", y: [<?php echo $min_temp[0];?>, <?php echo $max_temp[0];?>] }
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
	var chart1 = new CanvasJS.Chart("chartContainer1",{
    title:{
		text: " আদ্রতা গ্রাফ "
		},
		backgroundColor : "white",            
		axisY: {
			includeZero: false,
			suffix: " %",
			maximum: 90,
			gridThickness: 0
		},
    data: [{
	type: "line",
        dataPoints : [
	    	{ label: "<?php echo $fd[1]; ?>", y: <?php echo $humidity[5];?>},
			{ label: "<?php echo $fd[2]; ?>", y: <?php echo $humidity[4];?>},
			{ label: "<?php echo $fd[3]; ?>", y: <?php echo $humidity[3];?>},
			{ label: "<?php echo $fd[4]; ?>", y: <?php echo $humidity[2];?>},
			{ label: "<?php echo $fd[5]; ?>", y: <?php echo $humidity[1];?> },
			{ label: "<?php echo $fd[6]; ?>", y: <?php echo $humidity[0];?> }
	]
    }]
	});
	chart1.render();

	/*var chart2 = new CanvasJS.Chart("chartContainer2",{
    title :{
	text: "বৃষ্টিপাত"
    },
    backgroundColor : "white",            
		axisY: {
			includeZero: false,
			suffix: " %",
			maximum: 1,
			gridThickness: 0
		},
    data: [{
	type: "line",
	dataPoints : [
	    { label: "সোমবার", y: <?php echo $rain[0];?>},
		{ label: "মঙ্গলবার", y: <?php echo $rain[1];?>},
		{ label: "বুধবার", y: <?php echo $rain[2];?>},
		{ label: "বূহ:বার", y: <?php echo $rain[3];?>},
		{ label: "শুক্রবার", y: <?php echo $rain[4];?> },
		{ label: "শনিবার", y: <?php echo $rain[5];?> },
		{ label: "রবিবার", y: <?php echo $rain[6];?>}
	]
    }]
	});
	chart2.render();*/	  		 
	</script>
	<?php $conn->close(); ?>
</body>
</html>