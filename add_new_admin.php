<!DOCTYPE html>
<?php
	include "DBconnection.php";
	$email = $_POST['email'];
	$p1 = $_POST['pass1'];
	$p2 = $_POST['pass2'];
	$sql="INSERT INTO `admin`(`email`, `password`) VALUES ('$email','$p1')";
	$result = $conn->query($sql);
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
  	<script src="package/dist/sweetalert2.all.js"></script>
  	<script src="package/dist/sweetalert2.all.min.js"></script>
</head>
<body style="background-image: url(pic/b2.png);">
	<header><br><center> <h1 style="color: ;"><b>আবহাওয়া বার্তা</b></h1></center>
		<a href="admin_login.php"><button class="btn btn-success">Current Data</button></a>
		<a href="all_device.php"><button class="btn btn-warning">All Device Info</button></a>
		<a href="add_device.php"><button class="btn btn-info">Add New Device</button></a>
		<a href="edit_pro.php"><button class="btn btn-secondary">Change-Password</button></a>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
				Add New Admin
		</button>
		<a href="admin.php"><button class="btn btn-danger">Log-out</button></a>
		<br><br>
	</header>
		<br><br><br>
		<br><br><br><br><br><br>
		<br><br><br><br><br><br>
		<br><br><br>
		<footer>
			<br>
			Developed By Khaled & Tahmid
			<br>
		</footer>
		<script >
			Swal.fire({
				  position: 'center',
				  title: 'New Admin ADD',
				  type: 'success',
				  showConfirmButton: false,
				  timer: 1500
				})
		</script>
		<?php
			$conn->close();
			header('refresh:1.3 ;url=admin_login.php');
		?>
</body>
</html>
