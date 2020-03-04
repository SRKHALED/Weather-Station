<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>weather Station Admin</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="style.css">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script type="text/javascript" src="js/date_time.js"></script>
		<script src="js/jquery.min.js"></script>
	  	<script src="js/bootstrap.min.js"></script>
	  	<script src="package/dist/sweetalert2.all.js"></script>
  		<script src="package/dist/sweetalert2.all.min.js"></script>
		<script src="package/dist/sweetalert2.min.js"></script>
	</head>
	<body style="background-image: url(pic/b2.png);">
		<?php	
			include "DBconnection.php";
			if (isset($_SESSION["id"])){
				$email = $_SESSION["mail"];
				$pass = $_SESSION["pass"];
			}
			else{
				$email = $_POST['email'];
				$pass = $_POST['pass'];
			}
			$sql="SELECT * FROM admin WHERE `email` LIKE '$email' AND `password` LIKE '$pass'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()){
					$id = $row["admin_id"];
					$e = $row["email"];
					$p = $row["password"];
				}
				$_SESSION["id"]=$id;
				$_SESSION["mail"]=$e;
				$_SESSION["pass"]=$p;

				$i=0;
				$sql="SELECT * FROM `temperature` ORDER BY `T_id` DESC LIMIT 5";
			    $result = $conn->query($sql);
			    if ($result->num_rows > 0) {
			    	while($row = $result->fetch_assoc()){
			        	$temp[$i] = $row["current_temp"];
			        	$insert_time[$i] = $row["time_and_day"];
			        	$i++;
			        }
			    }
			    $i=0;
				$sql="SELECT `current_humi` FROM `humidity` ORDER BY `H_id` DESC LIMIT 5";
			    $result = $conn->query($sql);
			    if ($result->num_rows > 0) {
			    	while($row = $result->fetch_assoc()){
			        	$humidity[$i] = $row["current_humi"];
			        	$i++;
			        }
			    }
			    $i=0;
				$sql="SELECT `current_press` FROM `pressure` ORDER BY `P_id` DESC LIMIT 5";
			    $result = $conn->query($sql);
			    if ($result->num_rows > 0) {
			    	while($row = $result->fetch_assoc()){
			        	$pressure[$i] = $row["current_press"];
			        	$i++;
			        }
			    }
			    $i=0;
				$sql="SELECT `current_ws` FROM `wind_speed` ORDER BY `WS_id` DESC LIMIT 5";
			    $result = $conn->query($sql);
			    if ($result->num_rows > 0) {
			    	while($row = $result->fetch_assoc()){
			        	$ws[$i] = $row["current_ws"];
			        	$i++;
			        }
			    }
			    $i=0;
			    $sql="SELECT `current_rain_status` FROM `rain` ORDER BY `R_id` DESC LIMIT 5";
			    $result = $conn->query($sql);
			    if ($result->num_rows > 0) {
			    	while($row = $result->fetch_assoc()){
			        	$rn[$i] = $row["current_rain_status"];
			        	$i++;
			        }
			    }
			    // $current_time = date('Y-m-d H:i:s');
			    // echo $current_time."<br>";
			    // echo $current_time-$insert_time[1];
					?>
					<header><br><center> <h1 style="color: ;"><b>আবহাওয়া বার্তা</b></h1></center>
						<a href="admin_login.php" ><button class="btn btn-secondary active">Current Data</button></a>
						<a href="all_device.php"><button class="btn btn-warning">All Device Info</button></a>
						<a href="add_device.php"><button class="btn btn-info">Add New Device</button></a>
						<a href="edit_pro.php"><button class="btn btn-dark">Change-Password</button></a>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  							Add New Admin
						</button>
						<a href="admin.php"><button class="btn btn-danger">Log-out</button></a>
						<br><br>
					</header>
					<br><br>
					<div class="container">
						<div class="card">
						<table class="table table-striped"  style="text-align: center;">
	    					<thead class="thead-dark">
		    					<tr>
		    						<th scope="col">Time</th>
		    						<th scope="col">Temperature</th>
		    						<th scope="col">Humidity</th>
		    						<th scope="col">Pressuer</th>
		    						<th scope="col">Wind Speed</th>
		    						<th scope="col">Rain Status</th>
		    						<!-- <th scope="col">Device Location</th> -->
		    					</tr>
		    				</thead>
		    			<tbody >	
					<?php
						for ($i=0; $i <5 ; $i++) { 
				        	echo "<tr>
				        		<th scope='row'>".$insert_time[$i]."</th>
				      			<td>".$temp[$i]."<sup>o</sup><sub>C</sub></td>
				    			<td>".$humidity[$i]."%</td>
				    			<td>".$pressure[$i]."mbar</td>
				    			<td>".$ws[$i]."km/h</td>
				    			<td>".$rn[$i]."</td>
				    			</tr>";
				    	}
				    ?>
				    	</tbody>
				    </table>
					</div>
										<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document" style="font-family: 'Comic Sans MS', cursive, sans-serif;">
					    <div class="modal-content">
					      <div class="modal-header" style="color: blue;">
					        <h5 class="modal-title" id="exampleModalLabel">ADD NEW ADMIN</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <form method="post" action="add_new_admin.php">
								<div class ="form-group">
									<br><br>
									<label for="mail1"><b> E-mail</b></label>
									<div class="input-group">
									<input type="email" class="form-control" name="email" required style="border-radius: 50px;"/>
									</div>
									<label for="pass1"><b>Password</b></label>
									<input type="password" class="form-control" name="pass1" required style="border-radius: 50px";/>
									<label for="pass2"><b>Retype Password</b></label>
									<input type="password" class="form-control" name="pass2" required style="border-radius: 50px";/>
									<br />
									<input type="submit" class="btn btn-success" value="ADD NOW" style="width: 100%;border-radius: 50px;font-weight: bold;" />
									
								</div>					
							</form>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
					        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
					      </div>
					    </div>
					  </div>
					</div>
					<?php

			}
			else{
				?>
				<header><br><center> <h1 style="color: ;"><b>আবহাওয়া বার্তা</b></h1></center><br>
				</header>
				<br><br>
				<div class="container">
			<div class="row">
				<div class="col-md-2 box">		
				</div>
				<div class="col-md-8 box">
						<div class="card" style="background:#999999;border-radius: 35px; ">
							<div class="ch">
								<br>
								<h3>Admin Log-in</h3>
								<br>
							</div>
							<div class="row">
								<div class="col-md-5 box">
									<img src="pic/av1.PNG" alt="Avatar" class="avatar">
								</div>
								<div class="col-md-6 box" style="color: white;">
									<form method="post" action="admin_login.php">
										<div class ="form-group">
											<br><br>
											<label for="mail"><b> E-mail</b></label>
											<div class="input-group">
											<input type="email" class="form-control" name="email" required style="border-radius: 50px;" placeholder="" />
											</div>
											<label for="pass"><b>Password</b></label>
											<input type="password" class="form-control" name="pass" required style="border-radius: 50px";/>
											<br />
											<input type="submit" class="btn btn-success" value="LOG IN" style="width: 100%;border-radius: 50px; font-weight: bold; " />
											
										</div>					
									</form>
								</div>
								<div class="col-md-1 box">
								</div>
							</div>
							<h5 style="color: red; text-align: center; font-weight: bold;">Invalid E-mail Or Password</h5>
						</div>
				</div>
			</div>
		</div>
		<?php
			}  
		?>
		</div>
		<br><br><br>
		<footer>
			Developed By Khaled & Tahmid
		</footer>
	</body>
	<?php $conn->close(); ?>
</html>