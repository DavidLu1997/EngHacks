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
		$flag[name] = $row['name'];
		$flag[serving] = $row['serving'];
		$flag[vegetarian] = $row['vegetarian'];
		$flag[ingredients] = $row['ingredients'];
		$flag[calories] = $row['calories'];
		$flag[fat] = $row['fat'];
		$flag[saturated] = $row['saturated'];
		$flag[cholestrol] = $row['cholestrol'];
		$flag[sodium] = $row['sodium'];
		$flag[carbohydrate] = $row['carbohydrate'];
		$flag[fibre] = $row['fibre'];
		$flag[sugars] = $row['sugars'];
		$flag[protein] = $row['protein'];
		$flag[vitaminA] = $row['vitaminA'];
		$flag[vitaminC] = $row['vitaminC'];
		$flag[calcium] = $row['calcium'];
		$flag[iron] = $row['iron'];
		$flag[id] = $row['id'];

		echo json_encode($flag);
		$conn->close();
?>