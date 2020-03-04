<?php
	include "DBconnection.php";
	$t = $_GET['t'];
	$h = $_GET['h'];
	$p = $_GET['p'];
	$w = $_GET['w'];
	$r = $_GET['r'];
	$d = $_GET['d'];
	/*
	$t = $_POST['t'];
	$h = $_POST['h'];
	$p = $_POST['p'];
	$w = $_POST['w'];
	$r = $_POST['r'];
	$d = $_POST['d'];
	*/
	$sql1="SELECT * FROM `devices` WHERE `station_no` LIKE '$d' ";
	$result1 = $conn->query($sql1);
	if ($result1->num_rows > 0) {
		while($row = $result1->fetch_assoc()){
			$did = $row["D_id"];
			$dname = $row["name"];
			if (strpos($dname, 'Temperature') !== false) {
				echo "Temp :".$t."<br>";
				$sql="INSERT INTO `temperature`(`current_temp`, `D_id`) VALUES ('$t','$did')";
				$result = $conn->query($sql);
			}
			if (strpos($dname, 'Humidity') !== false) {
				echo "Humi :".$h."<br>";
				$sql="INSERT INTO `humidity`(`current_humi`, `D_id`) VALUES ('$h','$did')";
				$result = $conn->query($sql);
			}
			if (strpos($dname, 'Pressure') !== false) {
				echo "Press :".$p."<br>";
				$sql="INSERT INTO `pressure`(`current_press`, `D_id`) VALUES ('$p','$did')";
				$result = $conn->query($sql);
			}
			if (strpos($dname, 'Anemometer') !== false) {
				echo "WS :".$w."<br>";
				$sql="INSERT INTO `wind_speed`(`current_ws`, `D_id`) VALUES ('$w','$did')";
				$result = $conn->query($sql);
			}
			if (strpos($dname, 'Water') !== false) {
				if($r==1){
					$rn="YES";
				}
				else{
					$rn="NO";
				}
				echo "Rain :".$rn."<br>";
				$sql="INSERT INTO `rain`(`current_rain_status`, `D_id`) VALUES ('$rn','$did')";
				$result = $conn->query($sql);
			}
		}
		$h = date('H')+5;
		$m = date('i');
		if ($h==19 && $m>=30){
			$FT=0;
			$FMXT=0;
			$FMNT=100;
			$sql11="SELECT `current_temp` FROM `temperature` ORDER BY `T_id` DESC LIMIT 12";
			$result11 = $conn->query($sql11);
			if ($result11->num_rows > 0) {
				while($row = $result11->fetch_assoc()){
					$FT= $FT+$row["current_temp"];
					if($row["current_temp"]>$FMXT){
						$FMXT=$row["current_temp"];
					}
					if($row["current_temp"]<$FMNT){
						$FMNT=$row["current_temp"];
					}
				}
				$FT=round($FT/5,2)/98;
			}
			$sql11="SELECT AVG(`current_humi`) FROM `humidity` ORDER BY `H_id` DESC LIMIT 12";
			$result11 = $conn->query($sql11);
			if ($result11->num_rows > 0) {
				while($row = $result11->fetch_assoc()){
					$FH= round($row["AVG(`current_humi`)"],0);
				}
			}
			$sql11="SELECT AVG(`current_press`) FROM `pressure` ORDER BY `P_id` DESC LIMIT 12";
			$result11 = $conn->query($sql11);
			if ($result11->num_rows > 0) {
				while($row = $result11->fetch_assoc()){
					$FP= $row["AVG(`current_press`)"];
				}
			}
			$sql11="SELECT AVG(`current_ws`) FROM `wind_speed` ORDER BY `WS_id` DESC LIMIT 12";
			$result11 = $conn->query($sql11);
			if ($result11->num_rows > 0) {
				while($row = $result11->fetch_assoc()){
					$FWS= round($row["AVG(`current_ws`)"],2);
				}
			}
			$sql11="SELECT `current_rain_status` FROM `rain` ORDER BY `R_id` DESC LIMIT 12";
			$result11 = $conn->query($sql11);
			if ($result11->num_rows > 0) {
				while($row = $result11->fetch_assoc()){
					$FRS= $row["current_rain_status"];
					if ($FRS=="YES"){
						$FR=1;
						break;
					}
					else{
						$FR=0;
					}
				}
			}

			$day = date('y-m-d');
			$sql12="INSERT INTO `final_data`(`day`, `avg_tmp`, `max_temp`, `min_temp`, `avg_humi`, `avg_press`, `avg_ws`, `rain`) VALUES ('$day','$FT','$FMXT','$FMNT','$FH','$FP','$FWS','$FR')";
			$result12 = $conn->query($sql12);
		}
	}
	else {
		echo "Invalid Station Number";
	}

	$conn->close();

?>