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
	                  <button class='btn btn-secondary active' style='width: 125px;'>বর্তমান অবস্তা</button>
	                </a>
	              </li>
	              <li class='nav-item'>
	                <a class='nav-link' href='update.php'>
	                  <button class='btn btn-info' style='width: 125px;'>পূর্বাভাস</button>
	                </a>
	              </li>
	              <li class='nav-item'>
	                <a class='nav-link' href='privious.php'>
	                  <button class='btn btn-info' style='width: 125px;'>পূর্বের অবস্তা</button>
	                </a>
	              </li>
	            </ul>
	          </div>
        </nav>
    </header>
	<?php 
		include "DBconnection.php";
		include "E2B.php" ;
		include "knn.php";

		$day = date('m-d');
		$sql="SELECT * FROM `sun` WHERE `day` LIKE '$day'";
	    $result = $conn->query($sql);
	    if ($result->num_rows > 0) {
	    	while($row = $result->fetch_assoc()){
	        	$sun_rise = $row["sun_rise"];
	        	$sun_set = $row["sun_set"];  
	    	}
	    }
	    else{
	    	$sun_rise = '00:00';
	        $sun_set = '00:00';
	    }
	    $max_temp = 0;
		$min_temp = 1000;
		$i=0;
	    $sql="SELECT * FROM `temperature` ORDER BY `T_id` DESC LIMIT 12";
	    $result = $conn->query($sql);
	    if ($result->num_rows > 0) {
	    	while($row = $result->fetch_assoc()){
	        	$temp = $row["current_temp"];
	        	$insert_time = $row["time_and_day"];
	        	if ($i==0){
	        		$current_temp = $temp;
	        	} 
	    		if ($temp>$max_temp){
	    			$max_temp = $temp;
	    		}
		    	if ($temp<$min_temp){
		    		$min_temp = $temp;
		    	}
		    	$i++;
		    }
	    }
	    else{
	    	$current_temp = '--';
	    	$max_temp = '--';
			$min_temp = '--';
	    }

	    $sql="SELECT `current_humi` FROM `humidity` ORDER BY `H_id` DESC LIMIT 1";
	    $result = $conn->query($sql);
	    if ($result->num_rows > 0) {
	    	while($row = $result->fetch_assoc()){
	        	$humidity = $row["current_humi"]; 
	    	}
	    }
	    else{
	    	$humidity = '0';
	    }

	    $sql="SELECT `current_press` FROM `pressure` ORDER BY `P_id` DESC LIMIT 1";
	    $result = $conn->query($sql);
	    if ($result->num_rows > 0) {
	    	while($row = $result->fetch_assoc()){
	        	$pressure = $row["current_press"]; 
	    	}
	    }
	    else{
	    	$pressure = '0';
	    }

	    $sql="SELECT `current_ws` FROM `wind_speed` ORDER BY `WS_id` DESC LIMIT 1";
	    $result = $conn->query($sql);
	    if ($result->num_rows > 0) {
	    	while($row = $result->fetch_assoc()){
	        	$ws = $row["current_ws"]; 
	    	}
	    }
	    else{
	    	$ws = '0';
	    }
	    $i=0;
	    $sql="SELECT * FROM `final_data` ORDER BY `D_id` DESC LIMIT 365 ";
    	$result = $conn->query($sql);
    	if ($result->num_rows > 0) {
    		while($row = $result->fetch_assoc()){
        		$x1[$i] = $row["avg_tmp"];
        		$x2[$i] = $row["avg_humi"];
        		$x3[$i] = $row["avg_press"];
        		$y[$i] = $row["rain"];
        		$i++;
        	}
    	}
	?>
	<br>
	<div class="container"> 
	    <br>
	    <center>
	      <fieldset>
	      	<div class="one">
	      		<div class="row">
		      		<div class="col">
		      			<h2>সিলেট সিটি</h2>
		          		<h3>বাংলাদেশ</h3><br>
		          		<h3>এখন</h3>
		          		<h1><?php echo E2B::en2bn($current_temp); ?><sup>o</sup><sub>সে</sub></h1>
		          		<!-- <sub><?php //echo E2B::en2bn($insert_time);?></sub> -->
		      		</div>
		      		<div class="col">
		      			<div class="time">
		      				<span style="font-size:70px;">&#9729</span>
		      				<span style="font-size:70px;">&#9728</span>
		          			<span id="date_time"></span>
		            		<script type="text/javascript">window.onload = date_time('date_time');</script>
	          			</div>
	      			</div>
	      		</div>
	      		<hr>
	      	</div>
	      	<div class="two">
	      		<div class="row">
	        	<div class="col-sm-5">
	        		আদ্রতা : <?php echo E2B::en2bn($humidity); ?>%
	        		<hr>
	        		বায়ুচাপ : <?php echo E2B::en2bn($pressure); ?>  
	        		<hr>
	        		বাতাস এর গতি : <?php echo E2B::en2bn($ws); ?> কি.মি./ঘণ্টা
	        		<hr>
	        	</div>
	        	<div class="col-sm-3">
	        		অনুভব : <?php echo E2B::en2bn($current_temp); ?><sup>o</sup><sub>সে</sub>  
	        		<hr>
	        		সর্বোচ্চ : <?php echo E2B::en2bn($max_temp); ?><sup>o</sup><sub>সে</sub> 
	        		<hr>
	        		সর্বনিন্ম : <?php echo E2B::en2bn($min_temp); ?><sup>o</sup><sub>সে</sub> 
	        		<hr>
	        	</div>
	        	<div class="col-sm-4">
	        		বৃষ্টির সম্ভাব্যতা : <?php echo E2B::en2bn(knn::pbr($x1,$x2,$x3,$y,
	        			$temp,$humidity-5,$pressure)); ?>% 
	        		<hr>
	        		সূর্য উদয়   : <?php echo E2B::en2bn($sun_rise); ?>
	        		<hr>
	        		সূর্যাস্ত  : <?php echo E2B::en2bn($sun_set); ?> 
	        		<hr>
	        	</div>
	        </div>
	      	</div>
	      </fieldset>
	    </center>
	    <br>
	</div>
	<hr>
	<footer><br></footer>
	<script>
		btn.onclick = function() {
		  modal.style.display = "block";
		}
		span.onclick = function() {
		  modal.style.display = "none";
		}
	</script>
	<?php $conn->close(); ?>
</body>
</html>