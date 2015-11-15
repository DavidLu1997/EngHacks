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
		
		$name = $_REQUEST['name'];

		$r = $conn->query("SELECT * FROM food WHERE name LIKE $name;");

		while($row = mysql_fetch_arry($r)) {
			$flag[id] = $row[id];
		}

		print(json_encode($flag));
		$conn->close();
?>