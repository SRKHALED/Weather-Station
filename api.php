<?php
	//connection
	include "DBconnection.php";

	$action = 'fetch';

	if(isset($_GET['action'])){
		$action = $_GET['action'];
	}

	if($action == 'fetch'){
		$output = '';
		$sql = "SELECT * FROM devices";
		$query = $conn->query($sql);
		while($row = $query->fetch_assoc()){
			$output .= "
				<tr>
					<th scope='row'>".$row["station_no"]."</th>
	    			<td>".$row["D_id"]."</td>
	    			<td>".$row["name"]."</td>
	    			<td>".$row["model"]."</td>
	    			<td>".$row["location"]."</td>
	    			<td><form action='edit.php' method='post'>
							<input type='hidden' name='id' value='".$row["D_id"]."'/>
							<input type='submit' class='btn btn-success' value='Edit'/>
						 </form>
					<td><button class='btn btn-danger delete_product' data-id='".$row['D_id']."'>Delete</button></td>
				</tr>
			";
		}

		echo json_encode($output);
	}

	if($action == 'delete'){
		$id = $_POST['id'];
		$output = array();
		$sql = "DELETE FROM devices WHERE D_id = '$id'";
		if($conn->query($sql)){
			$output['status'] = 'success';
			$output['message'] = 'Device deleted successfully';
		}
		else{
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the member';
		}

		echo json_encode($output);

	}

?>