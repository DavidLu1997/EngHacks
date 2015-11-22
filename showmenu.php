<html>

<head>
	<title>UW Weekly Menu</title>
</head>

<body>
	<?php
		//Server information
		$servername = "localhost";
		$username = "watchew";
		$password = "enghacks";
		$dbname = "nutrition";

		$conn = new mysqli($servername, $username, $password, $dbname);

		if($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		echo "Connected sucessfully.<br>";

		echo "Weekly menu: <br>";
		$ids = $conn->query("SELECT * FROM menu;");

		while($id = $ids->fetch_assoc()){
			$id = $id['id'];
			//echo $id . "<br>";
			$item = $conn->query("SELECT * FROM food WHERE id = $id;");
			while($it = $item->fetch_assoc()){
				echo $it['name'] . " - " . $it['calories'] . " calories per serving<br>";
			}
			
		}
	?>
</body>

</html>