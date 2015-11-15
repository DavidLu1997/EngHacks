<?php
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	$password = $_POST["password"];
	$email = $_POST["email"];

	if($conn->query("SELECT * FROM users WHERE email = ?
	AND password = ? ") === TRUE){
		echo "Succcess";
	} else {
		echo "Sum Ting Wong<br>";
	}

	mysqli_stmt_bind_param($statement, "ss", $email, $password);
	mysqli_stmt_execute($statement);
	mysqli_stmt_store_result($statement);
	mysqli_stmt_bind_result($statement, $name, $email, $password);

	$user = array();
	while(mysqli_stmt_fetch($statement)){
		$user[name] = $name;
		$user[email] = $email;
		$user[password] = $password;
	}

	echo json_encode($user);
	mysqli_stmt_close($statement);
	
	mysqli_close($conn);

?>