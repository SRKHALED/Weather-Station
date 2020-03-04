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
</head>
<body style="background-image: url(pic/b2.png);">
	<header><br><center> <h1 style="color: ;"><b>আবহাওয়া বার্তা</b></h1></center>
		<a href="admin_login.php"><button class="btn btn-success">Current Data</button></a>
		<a href="all_device.php"><button class="btn btn-warning">All Device Info</button></a>
		<a href="add_device.php"><button class="btn btn-info">Add New Device</button></a>
		<a href="edit_pro.php"><button class="btn btn-secondary active">Change-Password</button></a>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
				Add New Admin
		</button>
		<a href="admin.php"><button class="btn btn-danger">Log-out</button></a>
		<br><br>
	</header>
	<?php	
		session_start();
		$id = $_SESSION["id"];
		$p1 = $_POST['pass1'];
		$p2 = $_POST['pass2'];
		include "DBconnection.php";
		$sql = "SELECT `password` FROM `admin` WHERE `admin_id` LIKE '$id'";
		$result = $conn->query($sql);
	    if ($result->num_rows > 0) {
	    	while($row = $result->fetch_assoc()){
	        	$p3 = $row["password"];
	        }
	    }
	    if($p1 == $p3){
			$sql="UPDATE `admin` SET `password`='$p2' WHERE `admin_id` LIKE '$id'";
			 $result = $conn->query($sql);
			?>
			<br><br><br>
			<br><br><br><br><br><br>
			<br><br><br><br><br><br>
			<br><br><br>
			<script >
				Swal.fire({
					  position: 'center',
					  title: 'Password Changed',
					  type: 'success',
					  showConfirmButton: false,
					  timer: 1500
					})
			</script>
		<?php 
		   header('refresh:1 ;url=edit_pro.php');
		}
		else{
			?>
			<br><br><br>
		<div class="container">
			<div class="row">
				<div class="col-md-3 box">		
				</div>
				<div class="col-md-7 box">
						<div class="card" style="background:#999999;border-radius: 35px;">
							<div class="ch">
								<br>
								<h3>Change Password</h3>
								<br>
							</div>
							<div class="row">
								<div class="col-md-2 box">		
								</div>
								<div class="col-md-8 box">
									<form method="post" action="change_now.php">
										<div class ="form-group">
											<div class="row" style="color: ; font-weight: bold;">
												<label for="model">Old Pssword :</label>
												<div class="input-group">
												<input type="password" class="form-control" name="pass1" required style="border-radius: 50px;"/>
												</div>
												<label for="model">New Pssword :</label>
												<div class="input-group">
												<input type="password" class="form-control" name="pass2" required style="border-radius: 50px;"/>
												</div>
											</div>
											<center><input type="submit" class="btn btn-success" value="CHANGE NOW" style="border-radius: 50px; font-weight: bold; width: 37%;" /></center>
										</div>
									</form>
									<h5 style="color: red; text-align: center; font-weight: bold;">Wrong Password</h5>
								</div>
							</div>
						</div>
					</div>
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
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
					      </div>
					    </div>
					  </div>
					</div>
			</div>
			<br><br><br>
			<?php
		}
		$conn->close();
	?>
<footer>
	Developed By Khaled & Tahmid
	<br>
</footer>
</body>
</html>