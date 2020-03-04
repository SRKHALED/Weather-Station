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
                  <button class='btn btn-info' style='width: 125px;'>বর্তমান অবস্তা</button>
                </a>
              </li>
              <li class='nav-item'>
                <a class='nav-link' href='update.php'>
                  <button class='btn btn-secondary active' style='width: 125px;'>পূর্বাভাস</button>
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
		include "LR.php";
		include "LR2.php";

		$sql="SELECT `current_temp` FROM `temperature` ORDER BY `T_id` DESC LIMIT 1";
	    $result = $conn->query($sql);
	    if ($result->num_rows > 0) {
	    	while($row = $result->fetch_assoc()){
	        	$temp = $row["current_temp"]; 
	    	}
	    }
	    else{
	    	$temp = '--';
	    }
	    $h = date('H')+5;
	    for($i=1; $i<=13; $i++){
	    	$t = $h+$i;
	    	if($t>23){
	    		$t = $t-24;
	    	}
	    	$hour[$i] = $t;
	    }
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
	    $d2 = date('m');
	    $i=0;
	    $sql="SELECT * FROM `final_data` WHERE `day` LIKE '_____$d2%' ";
    	$result = $conn->query($sql);
    	if ($result->num_rows > 0) {
    		while($row = $result->fetch_assoc()){
        		$y[$i] = $row["max_temp"];
        		$y2[$i] = $row["avg_tmp"];
        		$x[$i] = $i+1;
        		$i++;
        	}
    	}
    	$c = array_sum($y2)/count($y2);
    	$m = 0.1;
    	$pt = LR::pt($x,$y,$m,$c);
    	$d3 = date('d');
    	if ($d2>=11 || $d2==01){
	    	for($i=1; $i<7; $i++){
	    		$x = $pt[1]-($pt[0]*($d3+$i));
	    		$x1 = number_format($x,1);
	    		$fpt[$i] = $x1;	
	    	}
	    }
	    else{
	    	for($i=1; $i<7; $i++){
	    		$x = $pt[1]+($pt[0]*($d3+$i));
	    		$x1 = number_format($x,1);
	    		$fpt[$i] = $x1;	
	    	}
	    }
	    //For Houre Pradicon
	    $day2 = date('m-d');
		$sql="SELECT * FROM `sun` WHERE `day` LIKE '$day2'";
	    $result = $conn->query($sql);
	    if ($result->num_rows > 0) {
	    	while($row = $result->fetch_assoc()){
	        	$sun_rise = $row["sun_rise"];
	        	$sun_set = $row["sun_set"];  
	    	}
	    }
	    $t1[0] = $sun_rise[0];
    	$t1[1] = $sun_rise[1];
    	$sr = implode("", $t1);
    	$t1[0] = $sun_set[0];
	    $t1[1] = $sun_set[1];
	    $st = implode("", $t1);
	    $i=0;
		$sql="SELECT * FROM `temperature` ORDER BY `T_id` DESC LIMIT 12";
	    $result = $conn->query($sql);
	    if ($result->num_rows > 0) {
	    	while($row = $result->fetch_assoc()){
	        	$te = $row["current_temp"];
	        	$insert_time = $row["time_and_day"];
	        	$t1[0] = $insert_time[11];
	        	$t1[1] = $insert_time[12];
	        	$t3 = implode("", $t1);
        		$tx[$i]=$te;
        		$ty[$i] = $i+1;
        		$i++;
		    }
	    }
	    $c = 0;
    	$m = 0;
    	$pt2 = LR2::pt($tx,$ty,$m,$c);
    	$Ttemp = $temp;
    	//echo $pt2 ;
    	for($i=1; $i<=12; $i++){
    		if(($h+$i)>=$sr && ($h+$i)<=$st+11){
    			$Ttemp = $Ttemp+$pt2;
    			$x1 = number_format($Ttemp,1);
    			$hpt[$i] = $x1;
    		}
    		else{
    			$Ttemp = $Ttemp-$pt2;
    			$x1 = number_format($Ttemp,1);
    			$hpt[$i] = $x1;
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
		          		<h1><?php echo E2B::en2bn($temp); ?><sup>o</sup><sub>সে</sub></h1>
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
	      		<button class="collapsible">১২ ঘন্টার পূর্বাভাস</button>
	      		<div class="content">
		      		<div class="row">
		      			<?php
		      				echo "<div class='col-sm-4'><br>";
		      				for($i=1; $i<=12; $i++){
		      					echo E2B::en2bn($hour[$i]).":০০ : ".E2B::en2bn($hpt[$i])."<sup>o</sup><sub>সে</sub><hr>";
		      					if($i == 4 || $i == 8){
		      						echo "</div>";
		      						echo "<div class='col-sm-4'><br>";
		      					}
		      				}
		      				echo "</div>";
		      			?>
			        </div>
			    </div>
	      	</div>
	      	<hr>
	      	<div class="two">
	      		<button class="collapsible">৬ দিনের পূর্বাভাস</button>
	      		<div class="content">	
		      		<div class="row">
		      			<?php
		      				echo "<div class='col-sm-6'><br>";
		      				for($i=1; $i<7; $i++){
		      					echo $fd[$i]." : ".E2B::en2bn($fpt[$i])."<sup>o</sup><sub>সে</sub><hr>";
		      					if($i == 3){
		      						echo "</div>";
		      						echo "<div class='col-sm-6'><br>";
		      					}
		      				}
		      				echo "</div>";
		      			?>
			        </div>
			    </div>
	      	</div>
	      	<hr>
	      </fieldset>
	    </center>
	    <br>
	</div>
	<hr>
	<footer><br></footer>
	<script>
		var coll = document.getElementsByClassName("collapsible");
		var i;

		for (i = 0; i < coll.length; i++) {
		  coll[i].addEventListener("click", function() {
		    this.classList.toggle("active");
		    var content = this.nextElementSibling;
		    if (content.style.display === "block") {
		      content.style.display = "none";
		    } else {
		      content.style.display = "block";
		    }
		  });
		}
	</script>
	<?php $conn->close(); ?>
</body>
</html>