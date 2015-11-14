<html>

<head>
	<title>WatChew Database Crawler</title>
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

		//Clear DB
		$clearDB = 1;
		if($clearDB) {
			if($conn->query("delete from food;") === TRUE){
				echo "Table cleared. <br>";
			}
			else {
				echo "Error: delete from food;" . "<br>" .$conn->error;
			}
		}
		
		//Min and Max IDs for foods
		$min_id = 1000;
		$max_id = 1001;
		function crawl_page($url, $id, $conn)
		{
			echo "Crawling: " . $url . "<br>";
		    $seen[$url] = true;

		    $dom = new DOMDocument('1.0');
		    @$dom->loadHTMLFile($url);

		    $name = 'Test';
		    $serving = 100;
		    $vegetarian = 0;
		    $ingredients = 'Marijuana, LSD, Cocaine';
		    $calories = 9001;
		    $fat = 10;
		    $saturated = 1;
		    $cholestrol = 5;
		    $sodium = 3;
		    $carbohydrate = 2;
		    $fibre = 6;
		    $sugars = 37;
		    $protein = 200;
		    $vitaminA = 69;
		    $vitaminC = 42;
		    $calcium = 11;
		    $iron = 35;

		    //Get nutrition information from document
		    $nutrition_info = $dom->getElementsByTagName('span');
		    foreach($nutrition_info as $item) {
		    	echo $item->nodeValue . "<br>";
		    }

		    $sql = "INSERT INTO food (name, serving, vegetarian, ingredients, calories, fat, saturated, cholestrol, sodium, carbohydrate, fibre, sugars, protein, vitaminA, vitaminC, calcium, iron, id) VALUES ('$name', '$serving', '$vegetarian', '$ingredients', '$calories', '$fat', '$saturated', '$cholestrol', '$sodium', '$carbohydrate', '$fibre', '$sugars', '$protein', '$vitaminA', '$vitaminC', '$calcium', '$iron', '$id');";
			echo "Querying DB with: " . $sql . "<br>";
			if($conn->query($sql) === TRUE) {
				echo "Query sucessful, URL: ". $url . " crawled.<br>";
			} else {
				echo "Error: " . $sql . "<br>" .$conn->error;
			}
		}

		for($x = $min_id; $x <= $max_id; $x++) {
			crawl_page("https://uwaterloo.ca/food-services/menu/product/" . $x, $x, $conn);
		}
	?>
</body>

</html>