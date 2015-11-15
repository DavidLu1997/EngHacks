<?php
		//MySQL
		$servername = "localhost";
		$username = "watchew";
		$password = "enghacks";
		$dbname = "nutrition";

		$conn = new mysqli($servername, $username, $password, $dbname);

		if($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$id = $_POST["id"];

		$r = $conn->query("SELECT * FROM food WHERE id = '$id'");

		$flag = array();
		$row = $r->fetch_assoc();
		$flag[0] = $row['name'];
		$flag[1] = $row['serving'];
		$flag[3] = $row['ingredients'];
		$flag[4] = $row['calories'];
		$flag[5] = $row['fat'];
		$flag[6] = $row['saturated'];
		$flag[7] = $row['cholestrol'];
		$flag[8] = $row['sodium'];
		$flag[9] = $row['carbohydrate'];
		$flag[10] = $row['fibre'];
		$flag[11] = $row['sugars'];
		$flag[12] = $row['protein'];
		$flag[13] = $row['vitaminA'];
		$flag[14] = $row['vitaminC'];
		$flag[15] = $row['calcium'];
		$flag[16] = $row['iron'];
		$flag[17] = $row['id'];

		echo json_encode($flag);
		$conn->close();
?>