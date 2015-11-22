<?php
	//Server information
	$servername = "localhost";
	$username = "watchew";
	$password = "enghacks";
	$dbname = "nutrition";

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$name = $_POST["name"];
	$password = $_POST["password"];
	$email = $_POST["email"];

	if($conn->query("INSERT INTO users (name, email, password)
		VALUES ('$name', '$email', '$password')") === TRUE){
		echo "Success<br>";
	} else {
		echo "Sum Ting Wong<br>";
	}
	$conn->close();
?>