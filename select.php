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
		
		$name = $_POST["search_string"];

		//Trim
		$name = trim($name);

		$r = $conn->query("SELECT * FROM food WHERE name LIKE " . "'%" . $name . "%';");

		$flag = array();
		$i = 0;
		while($row = $r->fetch_assoc()) {
			$flag[$i] = $row['id'];
			$i++;
		}

		echo json_encode($flag);
		$conn->close();
?>