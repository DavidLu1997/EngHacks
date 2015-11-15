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

		$r = $conn->query("SELECT * FROM food WHERE name LIKE " . "'%" . $name . "%';");

		$flag = array();
		while($row = $r->fetch_assoc()) {
			$flag[id] = $row['id'];
		}

		echo json_encode($flag);
		$conn->close();
?>