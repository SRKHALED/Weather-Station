<!DOCTYPE html>
<?php 
	session_start();
	session_unset();
	session_destroy();
?>
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
	</head>
	<body style="background-image: url(pic/b2.png);">
		<header><br><center> <h1 style="color: ;"><b>আবহাওয়া বার্তা</b></h1><br></center>
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
											<input type="submit" class="btn btn-success" value="LOG IN" style="width: 100%;border-radius: 50px;font-weight: bold;" />
											
										</div>					
									</form>
								</div>
								<div class="col-md-1 box">
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>	
		<br><br>
		<footer>
			Developed By Khaled & Tahmid
		</footer>
	</body>
</html>