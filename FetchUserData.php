<?php
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	$password = $_POST["password"];
	$email = $_POST["email"];

	$rows = $conn->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");

	$user = array();
	while($row = $rows->fetch_assoc()) {
		$user[name] = $row['name'];
		$user[email] = $row['email'];
		$user[password] = $row['password'];
	}

	echo json_encode($user);
	mysqli_close($conn);

?>