<html>

<head>
	<title>UW Weekly Menu</title>
</head>

<body>
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
		echo "Connected suessfully.<br>";

		echo "Weekly menu: <br>";
		$ids = $conn->query("SELECT * FROM menu");

		foreach($ids as $id) {
			$item = $conn->query("SELECT * FROM food WHERE id = $id");
			echo $item . "<br>";
		}
	?>
</body>

</html>